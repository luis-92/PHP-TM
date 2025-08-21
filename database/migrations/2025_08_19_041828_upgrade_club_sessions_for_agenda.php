<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Upgrade de club_sessions para soportar agenda completa.
 *
 * Objetivos:
 * - Sustituir columna 'date' por 'session_date' (si existe).
 * - Mantener la regla UNIQUE por (club_id, session_date).
 * - Agregar campos de estado, palabra del día y “segmentos/tiempos” de agenda.
 * - Evitar el error MySQL 1553 al soltar el índice único usado por la FK.
 */
return new class extends Migration
{
    /**
     * Helper: verifica si existe un índice (por nombre) en una tabla.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $rows = DB::select('SHOW INDEX FROM `'.$table.'` WHERE `Key_name` = ?', [$indexName]);
        return !empty($rows);
    }

    public function up(): void
    {
        // 0) Asegurar que la FK de club_id no dependa del UNIQUE compuesto.
        //    Creamos un índice simple por 'club_id' si no existe.
        if (! $this->indexExists('club_sessions', 'club_sessions_club_id_idx')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->index('club_id', 'club_sessions_club_id_idx');
            });
        }

        // 1) Soltar el UNIQUE viejo (club_id, date) si existe, para poder renombrar la columna.
        if ($this->indexExists('club_sessions', 'club_session_day_uq')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->dropUnique('club_session_day_uq'); // evita 1553 gracias al idx de club_id creado arriba
            });
        }

        // 2) Renombrar 'date' -> 'session_date' si corresponde (requiere doctrine/dbal).
        if (Schema::hasColumn('club_sessions', 'date') && !Schema::hasColumn('club_sessions', 'session_date')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->renameColumn('date', 'session_date');
            });
        }

        // 3) Re-crear el UNIQUE por (club_id, session_date) con el mismo nombre.
        if (Schema::hasColumn('club_sessions', 'session_date') && ! $this->indexExists('club_sessions', 'club_session_day_uq')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->unique(['club_id', 'session_date'], 'club_session_day_uq');
            });
        }

        // 4) Agregar 'status' (Scheduled | Held | Canceled) si no existe.
        if (!Schema::hasColumn('club_sessions', 'status')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->string('status', 12)->default('Scheduled')->after('end_time');
            });
        }

        // 5) Palabra del día: palabra, definición, ejemplo (opcionales).
        Schema::table('club_sessions', function (Blueprint $t) {
            if (!Schema::hasColumn('club_sessions', 'word_of_day'))     $t->string('word_of_day', 100)->nullable()->after('status');
            if (!Schema::hasColumn('club_sessions', 'word_definition')) $t->text('word_definition')->nullable()->after('word_of_day');
            if (!Schema::hasColumn('club_sessions', 'word_example'))    $t->text('word_example')->nullable()->after('word_definition');
        });

        // 6) Segmentos de agenda: cada uno con hora de inicio (TIME) y duración en minutos (SMALLINT).
        $timeCols = [
            ['welcome_at','welcome_minutes'],
            ['opening_at','opening_minutes'],
            ['toastmaster_intro_at','toastmaster_intro_minutes'],
            ['roles_intro_at','roles_intro_minutes'],
            ['table_topics_at','table_topics_minutes'],
            ['break_at','break_minutes'],
            ['prepared_speeches_at','prepared_speeches_minutes'],
            ['general_evaluation_at','general_evaluation_minutes'],
            ['toastmaster_closing_at','toastmaster_closing_minutes'],
            ['presidency_time_at','presidency_time_minutes'],
            ['timer_report_at','timer_report_minutes'],
            ['photo_at','photo_minutes'],
        ];

        Schema::table('club_sessions', function (Blueprint $t) use ($timeCols) {
            foreach ($timeCols as [$at, $mins]) {
                if (!Schema::hasColumn('club_sessions', $at))   $t->time($at)->nullable()->after('word_example');
                if (!Schema::hasColumn('club_sessions', $mins)) $t->unsignedSmallInteger($mins)->nullable()->after($at);
            }
        });

        // 7) Índice útil por fecha para ordenar/buscar sesiones.
        if (Schema::hasColumn('club_sessions', 'session_date') && ! $this->indexExists('club_sessions', 'club_sessions_session_date_idx')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->index('session_date', 'club_sessions_session_date_idx');
            });
        }
    }

    public function down(): void
    {
        // Revertimos en orden inverso y con chequeos de existencia para evitar errores.

        // 1) Quitar índice por session_date si lo agregamos.
        if ($this->indexExists('club_sessions', 'club_sessions_session_date_idx')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->dropIndex('club_sessions_session_date_idx');
            });
        }

        // 2) Quitar UNIQUE (club_id, session_date) si existe.
        if ($this->indexExists('club_sessions', 'club_session_day_uq')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->dropUnique('club_session_day_uq');
            });
        }

        // 3) Eliminar columnas agregadas (status, word_*, y segmentos de agenda).
        $dropCols = [
            'status',
            'word_of_day','word_definition','word_example',
            'welcome_at','welcome_minutes',
            'opening_at','opening_minutes',
            'toastmaster_intro_at','toastmaster_intro_minutes',
            'roles_intro_at','roles_intro_minutes',
            'table_topics_at','table_topics_minutes',
            'break_at','break_minutes',
            'prepared_speeches_at','prepared_speeches_minutes',
            'general_evaluation_at','general_evaluation_minutes',
            'toastmaster_closing_at','toastmaster_closing_minutes',
            'presidency_time_at','presidency_time_minutes',
            'timer_report_at','timer_report_minutes',
            'photo_at','photo_minutes',
        ];
        Schema::table('club_sessions', function (Blueprint $t) use ($dropCols) {
            foreach ($dropCols as $c) {
                if (Schema::hasColumn('club_sessions', $c)) {
                    $t->dropColumn($c);
                }
            }
        });

        // 4) Renombrar 'session_date' -> 'date' si aplica.
        if (Schema::hasColumn('club_sessions', 'session_date') && !Schema::hasColumn('club_sessions', 'date')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->renameColumn('session_date', 'date'); // requiere doctrine/dbal
            });
        }

        // 5) Re-crear UNIQUE original (club_id, date) si la columna 'date' existe.
        if (Schema::hasColumn('club_sessions', 'date') && ! $this->indexExists('club_sessions', 'club_session_day_uq')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->unique(['club_id','date'], 'club_session_day_uq');
            });
        }

        // 6) (Opcional) Quitar el índice simple por club_id si lo agregamos en up()
        if ($this->indexExists('club_sessions', 'club_sessions_club_id_idx')) {
            Schema::table('club_sessions', function (Blueprint $t) {
                $t->dropIndex('club_sessions_club_id_idx');
            });
        }
    }
};
