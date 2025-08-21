<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClubSessionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

// Operaciones de Backpack
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * CRUD para crear/editar sesiones de club.
 *
 * Puntos clave:
 * - En el formulario, los campos de asignación de funcionarios (president, timer, etc.)
 *   se implementan con select2_from_ajax (NO 'relationship'), para no requerir
 *   relaciones directas en el modelo ClubSession y evitar el 500.
 * - Esos campos "fake" se guardan manualmente en la tabla
 *   session_functionary_role_assignments en saveRoleAssignments().
 * - Se calculan defaults (fecha/horas/minutos) ANTES de validar.
 */
class ClubSessionCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;
    use FetchOperation;

    /** Configuración base del CRUD */
    public function setup(): void
    {
        CRUD::setModel(\App\Models\ClubSession::class);
        // Debe coincidir con la ruta definida en routes/backpack/custom.php (Route::crud)
        CRUD::setRoute(config('backpack.base.route_prefix') . '/clubsession');
        CRUD::setEntityNameStrings('session', 'sessions');

        // Evitar N+1 en List
        CRUD::addClause('with', ['club:id,name']);
    }

    /* ==========================================================
     |                        LIST OPERATION
     ========================================================== */
    protected function setupListOperation(): void
    {
        CRUD::addColumn([
            'name'      => 'club',
            'type'      => 'relationship',
            'label'     => 'Club',
            'attribute' => 'name',
        ]);
        CRUD::addColumn(['name' => 'session_date', 'type' => 'date', 'label' => 'Date']);
        CRUD::addColumn(['name' => 'session_type', 'type' => 'text', 'label' => 'Type']);
        CRUD::addColumn(['name' => 'start_time',   'type' => 'time', 'label' => 'Start']);
        CRUD::addColumn(['name' => 'end_time',     'type' => 'time', 'label' => 'End']);
        CRUD::addColumn(['name' => 'status',       'type' => 'text', 'label' => 'Status']);
        CRUD::addColumn(['name' => 'location',     'type' => 'text', 'label' => 'Location']);
        CRUD::addColumn(['name' => 'word_of_day',  'type' => 'text', 'label' => 'Word']);

        // Filtro por club
        CRUD::addFilter(
            ['type' => 'select2', 'name' => 'club_id', 'label' => 'Club'],
            fn() => \App\Models\Club::orderBy('name')->pluck('name', 'id')->toArray(),
            fn($v) => CRUD::addClause('where', 'club_id', $v)
        );

        // Filtro por rango de fechas
        CRUD::addFilter(
            ['type' => 'date_range', 'name' => 'session_date', 'label' => 'Date range'],
            false,
            function ($value) {
                $d = json_decode($value, true);
                if (!empty($d['from'])) CRUD::addClause('where', 'session_date', '>=', $d['from']);
                if (!empty($d['to']))   CRUD::addClause('where', 'session_date', '<=', $d['to']);
            }
        );

        // Filtros por tipo y estatus
        CRUD::addFilter(
            ['type' => 'dropdown', 'name' => 'session_type', 'label' => 'Type'],
            ['Regular'=>'Regular','Contest'=>'Contest','Officer'=>'Officer','Special'=>'Special'],
            fn($v) => CRUD::addClause('where', 'session_type', $v)
        );
        CRUD::addFilter(
            ['type' => 'dropdown', 'name' => 'status', 'label' => 'Status'],
            ['Scheduled'=>'Scheduled','Held'=>'Held','Canceled'=>'Canceled'],
            fn($v) => CRUD::addClause('where', 'status', $v)
        );
    }

    /* ==========================================================
     |                     CREATE / UPDATE FORM
     ========================================================== */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(ClubSessionRequest::class);

        /* ---------- Pestaña: General ---------- */
        // Club (relationship con AJAX + inline create)
        CRUD::addField([
            'name'        => 'club',
            'type'        => 'relationship',
            'label'       => 'Club',
            'attribute'   => 'name',
            'ajax'        => true,
            'minimum_input_length' => 2,
            'placeholder' => 'Busca por nombre…',
            'inline_create' => ['entity' => 'club', 'force_select' => true],
            'options'     => fn($q) => $q->orderBy('name'),
            'tab'         => 'General',
        ]);

        // Fecha de sesión
        CRUD::addField([
            'name' => 'session_date',
            'type' => 'date_picker',
            'label' => 'Date',
            'date_picker_options' => ['format' => 'dd/mm/yyyy', 'todayBtn' => true],
            'tab'  => 'General',
        ]);

        // Tipo y estatus
        CRUD::addField([
            'name' => 'session_type', 'type' => 'select_from_array', 'label' => 'Type',
            'options' => ['Regular'=>'Regular','Contest'=>'Contest','Officer'=>'Officer','Special'=>'Special'],
            'allows_null' => true,
            'tab' => 'General',
        ]);
        CRUD::addField([
            'name' => 'status', 'type' => 'select_from_array', 'label' => 'Status',
            'options' => ['Scheduled'=>'Scheduled','Held'=>'Held','Canceled'=>'Canceled'],
            'default' => 'Scheduled',
            'tab' => 'General',
        ]);

        // Horas generales
        CRUD::addField(['name'=>'planned_time','type'=>'time','label'=>'Planned time','tab'=>'General']);
        CRUD::addField(['name'=>'start_time',  'type'=>'time','label'=>'Start time',  'tab'=>'General']);
        CRUD::addField(['name'=>'end_time',    'type'=>'time','label'=>'End time',    'tab'=>'General']);

        CRUD::addField(['name'=>'location','type'=>'text','label'=>'Location','tab'=>'General']);
        CRUD::addField(['name'=>'notes','type'=>'textarea','label'=>'Notes','tab'=>'General']);

        /* ---------- Pestaña: Word of the day ---------- */
        CRUD::addField(['name'=>'word_of_day','type'=>'text','label'=>'Word of the day','tab'=>'Word']);
        CRUD::addField(['name'=>'word_definition','type'=>'textarea','label'=>'Definition','tab'=>'Word']);
        CRUD::addField(['name'=>'word_example','type'=>'textarea','label'=>'Example','tab'=>'Word']);

        /* ---------- Pestaña: Agenda (tiempos) ----------
         * NOTA: Si en DB guardas columnas TIME, valida formato en el Request (H:i)
         * y considera castear como string en el modelo para evitar issues con datetime.
         */
        $blocks = [
            ['welcome_at','welcome_minutes','Welcome','mins', 2],
            ['opening_at','opening_minutes','Opening','mins', 3],
            ['toastmaster_intro_at','toastmaster_intro_minutes','TM intro','mins', 3],
            ['roles_intro_at','roles_intro_minutes','Roles intro + Word','mins', 8],
            ['table_topics_at','table_topics_minutes','Table Topics','mins', 25],
            ['break_at','break_minutes','Break','mins', 10],
            ['prepared_speeches_at','prepared_speeches_minutes','Prepared Speeches','mins', null],
            ['general_evaluation_at','general_evaluation_minutes','General Evaluation','mins', null],
            ['toastmaster_closing_at','toastmaster_closing_minutes','TM closing','mins', 2],
            ['presidency_time_at','presidency_time_minutes','Presidency time','mins', 10],
            ['timer_report_at','timer_report_minutes','Timer report','mins', 2],
            ['photo_at','photo_minutes','Photo','mins', 2],
        ];
        foreach ($blocks as [$at, $min, $label, $minLabel, $default]) {
            CRUD::addField(['name'=>$at,'type'=>'time','label'=>$label,'tab'=>'Agenda']);
            $field = ['name'=>$min,'type'=>'number','label'=>$minLabel,'attributes'=>['min'=>0,'max'=>240],'tab'=>'Agenda'];
            if ($default !== null) $field['default'] = $default;
            CRUD::addField($field);
        }

        /* ---------- Pestaña: Assignments ----------
         * Campos "fake" que NO son relaciones del modelo ClubSession.
         * Usamos select2_from_ajax para listar miembros del club seleccionado.
         * Luego, en saveRoleAssignments(), se insertan filas en
         * session_functionary_role_assignments.
         */
        $assignFields = [
            'role_official_assembly' => ['Official of Assembly (SAA)', 'sergeant_at_arms'],
            'role_president'         => ['President',                   'president'],
            'role_toastmaster'       => ['Toastmaster of the Day',      'toastmaster'],
            'role_general_evaluator' => ['General Evaluator',           'general_evaluator'],
            'role_grammarian'        => ['Grammarian',                  'grammarian'],
            'role_ah_counter'        => ['Ah-Counter',                  'ah_counter'],
            'role_timer'             => ['Timer',                       'timer'],
        ];
        foreach ($assignFields as $name => [$label, $code]) {
            CRUD::addField([
                'name'        => $name, // campo fake (no mapea a DB de club_sessions)
                'label'       => $label,
                'type'        => 'select2_from_ajax',
                'data_source' => backpack_url('clubsession/fetch/members-by-club'), // método fetchMembersByClub()
                'placeholder' => 'Selecciona miembro…',
                'minimum_input_length' => 1,
                'method'      => 'POST',
                'dependencies'=> ['club'],               // se recarga al cambiar el club
                'include_all_form_fields' => true,       // envía 'club' al endpoint
                'attribute'   => 'name',                 // campo visible del modelo Member
                'tab'         => 'Assignments',
                'allows_null' => true,
            ]);
        }
    }

    /** Update usa el mismo formulario que Create */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    /* ==========================================================
     |                    STORE / UPDATE OVERRIDES
     |  (defaults antes de validar + guardado de assignments)
     ========================================================== */

    /** Crear */
    public function store()
    {
        // 1) Completar defaults ANTES de validar (fecha / horas / minutos)
        $this->applySessionDefaultsToRequest();

        // 2) Validar (usa ClubSessionRequest)
        $this->crud->setRequest($this->crud->validateRequest());

        // 3) Crear la sesión (solo columnas de club_sessions)
        $entry = $this->crud->create($this->crud->getStrippedSaveRequest());

        // 4) Guardar asignaciones (presidente, timer, etc.)
        $this->saveRoleAssignments($entry->id, (int)$entry->club_id);

        // 5) Responder
        \Alert::success('Session created.')->flash();
        return $this->crud->performSaveAction($entry->getKey());
    }

    /** Actualizar */
    public function update()
    {
        // 1) Defaults ANTES de validar
        $this->applySessionDefaultsToRequest();

        // 2) Validar
        $this->crud->setRequest($this->crud->validateRequest());

        // 3) Actualizar sesión
        $entry = $this->crud->update($this->crud->getCurrentEntryId(), $this->crud->getStrippedSaveRequest());

        // 4) Reescribir asignaciones (idempotente)
        $this->saveRoleAssignments($entry->id, (int)$entry->club_id, replace: true);

        \Alert::success('Session updated.')->flash();
        return $this->crud->performSaveAction($entry->getKey());
    }

    /* ==========================================================
     |                           FETCH
     |  Endpoints AJAX para llenar combos (Backpack FetchOperation)
     ========================================================== */

    /**
     * Devuelve miembros del club seleccionado para los select2_from_ajax
     * Ruta automática: /admin/clubsession/fetch/members-by-club  (POST)
     * (Backpack genera la ruta a partir del nombre del método)
     */
    public function fetchMembersByClub()
    {
        // Gracias a 'include_all_form_fields' recibimos todos los campos del form.
        // 'club' es el nombre del field relationship del club en el formulario.
        $clubId = request('form')['club'] ?? request('club_id') ?? null;

        return $this->fetch(\App\Models\Member::class, ['id','name'], function ($q) use ($clubId) {
            if ($clubId) $q->where('club_id', (int)$clubId);
            $q->orderBy('name');
        });
    }

    /* ==========================================================
     |                          HELPERS
     ========================================================== */

    /**
     * Completa valores por defecto directamente en el Request:
     * - session_date: próxima fecha según meeting_day del club (si está vacío)
     * - start_time: meeting_time del club (si está vacío)
     * - end_time: start_time + 120 min (si está vacío)
     * - minutos por defecto para bloques comunes de agenda
     */
    protected function applySessionDefaultsToRequest(): void
    {
        $request = $this->crud->getRequest();
        $clubId = (int) ($request->input('club') ?? $request->input('club_id'));

        $club = $clubId ? \App\Models\Club::find($clubId) : null;

        // Fecha sugerida (próxima al meeting_day del club)
        $sessionDate = $request->input('session_date');
        if (!$sessionDate && $club && !empty($club->meeting_day)) {
            $sessionDate = $this->nextDateForWeekday($club->meeting_day);
        }

        // Hora inicio sugerida
        $start = $request->input('start_time');
        if (!$start && $club && !empty($club->meeting_time)) {
            $start = $club->meeting_time; // 'H:i' o 'H:i:s'
        }

        // Hora fin sugerida = inicio + 120 min
        $end = $request->input('end_time');
        if (!$end && $start) {
            try {
                $end = Carbon::parse($start)->addMinutes(120)->format('H:i');
            } catch (\Throwable $e) {}
        }

        $merge = [];
        if ($sessionDate) $merge['session_date'] = $sessionDate;
        if ($start)       $merge['start_time']   = $start;
        if ($end)         $merge['end_time']     = $end;

        // Minutos por defecto si vienen vacíos
        $defaults = [
            'welcome_minutes' => 2,
            'opening_minutes' => 3,
            'toastmaster_intro_minutes' => 3,
            'roles_intro_minutes' => 8,
            'table_topics_minutes' => 25,
            'break_minutes' => 10,
            'toastmaster_closing_minutes' => 2,
            'presidency_time_minutes' => 10,
            'timer_report_minutes' => 2,
            'photo_minutes' => 2,
        ];
        foreach ($defaults as $key => $val) {
            if ($request->filled($key)) continue;
            $merge[$key] = $val;
        }

        $request->merge($merge);
        $this->crud->setRequest($request);
    }

    /**
     * Inserta/actualiza asignaciones en session_functionary_role_assignments.
     * Lee los campos "fake" del formulario (role_president, role_timer, etc.).
     * Si replace=true, borra previamente las asignaciones de ese set de roles.
     *
     * Requiere una tabla como:
     *  - club_session_id (FK)
     *  - member_id (FK nullable)
     *  - role_code (string)  // e.g. 'president', 'timer', ...
     *  - created_at / updated_at
     *
     * Ajusta los nombres si tu migración difiere.
     */
    protected function saveRoleAssignments(int $clubSessionId, int $clubId, bool $replace = false): void
    {
        // Mapa: field_name => role_code
        $map = [
            'role_official_assembly' => 'sergeant_at_arms',
            'role_president'         => 'president',
            'role_toastmaster'       => 'toastmaster',
            'role_general_evaluator' => 'general_evaluator',
            'role_grammarian'        => 'grammarian',
            'role_ah_counter'        => 'ah_counter',
            'role_timer'             => 'timer',
        ];

        if ($replace) {
            DB::table('session_functionary_role_assignments')
                ->where('club_session_id', $clubSessionId)
                ->whereIn('role_code', array_values($map))
                ->delete();
        }

        $req = $this->crud->getRequest();

        foreach ($map as $field => $roleCode) {
            $memberId = $req->input($field);

            // Si no se seleccionó en el form, intenta sugerir desde comité (opcional)
            if (!$memberId && in_array($roleCode, ['president','sergeant_at_arms'])) {
                $memberId = $this->suggestOfficer($clubId, $roleCode);
            }

            if ($memberId) {
                DB::table('session_functionary_role_assignments')->insert([
                    'club_session_id' => $clubSessionId,
                    'member_id'       => (int)$memberId,
                    'role_code'       => $roleCode,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }
    }

    /**
     * Devuelve el miembro vigente del comité para un role_code dado (si existe).
     * Requiere una tabla tipo club_officers con:
     *  club_id, member_id, role_code, term_start, term_end, is_active
     * Ajusta si tu esquema es distinto.
     */
    protected function suggestOfficer(int $clubId, string $roleCode): ?int
    {
        $row = DB::table('club_officers')
            ->select('member_id')
            ->where('club_id', $clubId)
            ->where('role_code', $roleCode)
            ->where(function ($q) {
                $today = now()->toDateString();
                $q->whereNull('term_start')->orWhere('term_start', '<=', $today);
            })
            ->where(function ($q) {
                $today = now()->toDateString();
                $q->whereNull('term_end')->orWhere('term_end', '>=', $today);
            })
            ->when(DB::getSchemaBuilder()->hasColumn('club_officers', 'is_active'), function ($q) {
                $q->where('is_active', 1);
            })
            ->orderByDesc('term_start')
            ->first();

        return $row?->member_id ? (int)$row->member_id : null;
    }

    /**
     * Calcula la siguiente fecha (Y-m-d) para un día de la semana dado.
     * Acepta abreviaturas en inglés o español: Mon..Sun / Lun..Dom
     */
    protected function nextDateForWeekday(string $day): string
    {
        $map = [
            'Mon'=>'monday','Tue'=>'tuesday','Wed'=>'wednesday','Thu'=>'thursday','Fri'=>'friday','Sat'=>'saturday','Sun'=>'sunday',
            'Lun'=>'monday','Mar'=>'tuesday','Mié'=>'wednesday','Jue'=>'thursday','Vie'=>'friday','Sáb'=>'saturday','Dom'=>'sunday',
        ];
        $norm = $map[$day] ?? strtolower($day);
        $date = Carbon::today();
        if (strtolower($date->englishDayOfWeek) !== $norm) {
            $date = $date->next($norm);
        }
        return $date->toDateString();
    }
}
