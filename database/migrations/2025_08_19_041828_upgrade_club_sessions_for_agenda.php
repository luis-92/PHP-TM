<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('club_sessions', function (Blueprint $t) {
            // 1) soltar unique viejo (usaba 'date') para poder renombrar
            try { $t->dropUnique('club_session_day_uq'); } catch (\Throwable $e) {}

            // 2) renombrar 'date' -> 'session_date'
            if (Schema::hasColumn('club_sessions', 'date') && !Schema::hasColumn('club_sessions', 'session_date')) {
                $t->renameColumn('date', 'session_date'); // requiere doctrine/dbal
            }

            // 3) re-crear unique por (club_id, session_date)
            $t->unique(['club_id', 'session_date'], 'club_session_day_uq');

            // 4) status de la sesión (Scheduled | Held | Canceled)
            if (!Schema::hasColumn('club_sessions', 'status')) {
                $t->string('status', 12)->default('Scheduled')->after('end_time');
            }

            // 5) Palabra del día (del PDF)
            //    - palabra, definición, ejemplo 【turn1file0†L47-L55】
            if (!Schema::hasColumn('club_sessions', 'word_of_day'))      $t->string('word_of_day', 100)->nullable()->after('status');
            if (!Schema::hasColumn('club_sessions', 'word_definition'))  $t->text('word_definition')->nullable()->after('word_of_day');
            if (!Schema::hasColumn('club_sessions', 'word_example'))     $t->text('word_example')->nullable()->after('word_definition');

            // 6) Hitos/segmentos de agenda (hora + minutos) según el orden del PDF
            //    Bienvenida, Inicio, TM Intro, Roles+Palabra, Topics, Receso,
            //    Discursos, Evaluación General (incluye subreportes), Cierre TM,
            //    Tiempo de presidencia, Reporte cronómetro, Foto
            //    【turn1file0†L59-L71】【turn1file0†L74-L105】
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

            foreach ($timeCols as [$at, $mins]) {
                if (!Schema::hasColumn('club_sessions', $at))   $t->time($at)->nullable()->after('word_example');
                if (!Schema::hasColumn('club_sessions', $mins)) $t->unsignedSmallInteger($mins)->nullable()->after($at);
            }

            // 7) índice útil por fecha
            try { $t->index('session_date', 'club_sessions_session_date_idx'); } catch (\Throwable $e) {}
        });
    }

    public function down(): void
    {
        Schema::table('club_sessions', function (Blueprint $t) {
            // quitar índices añadidos
            try { $t->dropIndex('club_sessions_session_date_idx'); } catch (\Throwable $e) {}

            // soltar unique y volver al anterior si existe la columna 'date'
            try { $t->dropUnique('club_session_day_uq'); } catch (\Throwable $e) {}

            // eliminar columnas agregadas
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
            foreach ($dropCols as $c) {
                if (Schema::hasColumn('club_sessions', $c)) $t->dropColumn($c);
            }

            // renombrar 'session_date' -> 'date' (si estaba)
            if (Schema::hasColumn('club_sessions', 'session_date') && !Schema::hasColumn('club_sessions', 'date')) {
                $t->renameColumn('session_date', 'date');
            }

            // re-crear unique original sobre (club_id, date)
            if (Schema::hasColumn('club_sessions', 'date')) {
                try { $t->unique(['club_id','date'], 'club_session_day_uq'); } catch (\Throwable $e) {}
            }
        });
    }
};
