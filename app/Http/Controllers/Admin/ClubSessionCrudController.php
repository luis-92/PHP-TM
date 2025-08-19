<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClubSessionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

// Operaciones
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClubSessionCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;
    use FetchOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\ClubSession::class);
        // Asegúrate que coincide con routes/backpack/custom.php → Route::crud('clubsession', ...)
        CRUD::setRoute(config('backpack.base.route_prefix') . '/clubsession');
        CRUD::setEntityNameStrings('session', 'sessions');

        // Evitar N+1
        CRUD::addClause('with', ['club:id,name']);
    }

    /* -------------------------- LIST -------------------------- */
    protected function setupListOperation(): void
    {
        CRUD::addColumn(['name' => 'club', 'type' => 'relationship', 'label' => 'Club', 'attribute' => 'name']);
        CRUD::addColumn(['name' => 'session_date', 'type' => 'date', 'label' => 'Date']);
        CRUD::addColumn(['name' => 'session_type', 'type' => 'text', 'label' => 'Type']);
        CRUD::addColumn(['name' => 'start_time', 'type' => 'time', 'label' => 'Start']);
        CRUD::addColumn(['name' => 'end_time',   'type' => 'time', 'label' => 'End']);
        CRUD::addColumn(['name' => 'status',     'type' => 'text', 'label' => 'Status']);
        CRUD::addColumn(['name' => 'location',   'type' => 'text', 'label' => 'Location']);
        CRUD::addColumn(['name' => 'word_of_day','type' => 'text', 'label' => 'Word']);

        // Filtros
        CRUD::addFilter(
            ['type' => 'select2', 'name' => 'club_id', 'label' => 'Club'],
            fn() => \App\Models\Club::orderBy('name')->pluck('name', 'id')->toArray(),
            fn($v) => CRUD::addClause('where', 'club_id', $v)
        );

        CRUD::addFilter(
            ['type' => 'date_range', 'name' => 'session_date', 'label' => 'Date range'],
            false,
            function ($value) {
                $d = json_decode($value, true);
                if (!empty($d['from'])) CRUD::addClause('where', 'session_date', '>=', $d['from']);
                if (!empty($d['to']))   CRUD::addClause('where', 'session_date', '<=', $d['to']);
            }
        );

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

    /* -------------------------- CREATE/UPDATE FORM -------------------------- */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(ClubSessionRequest::class);

        // Club (relationship + AJAX + inline create)
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

        // Fecha (si no la eliges, luego se sugiere la próxima según el club)
        CRUD::addField([
            'name' => 'session_date', 'type' => 'date_picker', 'label' => 'Date',
            'date_picker_options' => ['format' => 'dd/mm/yyyy', 'todayBtn' => true],
            'tab'  => 'General',
        ]);

        // Tipo de sesión y estado
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

        // Horas generales (si faltan, luego se completan con meeting_time y +120 min)
        CRUD::addField(['name'=>'planned_time','type'=>'time','label'=>'Planned time','tab'=>'General']);
        CRUD::addField(['name'=>'start_time',  'type'=>'time','label'=>'Start time',  'tab'=>'General']);
        CRUD::addField(['name'=>'end_time',    'type'=>'time','label'=>'End time',    'tab'=>'General']);

        CRUD::addField(['name'=>'location','type'=>'text','label'=>'Location','tab'=>'General']);
        CRUD::addField(['name'=>'notes','type'=>'textarea','label'=>'Notes','tab'=>'General']);

        // Palabra del día
        CRUD::addField(['name'=>'word_of_day','type'=>'text','label'=>'Word of the day','tab'=>'Word']);
        CRUD::addField(['name'=>'word_definition','type'=>'textarea','label'=>'Definition','tab'=>'Word']);
        CRUD::addField(['name'=>'word_example','type'=>'textarea','label'=>'Example','tab'=>'Word']);

        /* ---------------- Agenda (tiempos sugeridos) ---------------- */
        $blocks = [
            ['welcome_at','welcome_minutes','Welcome','mins', 2],
            ['opening_at','opening_minutes','Opening','mins', 3],
            ['toastmaster_intro_at','toastmaster_intro_minutes','TM intro','mins', 3],
            ['roles_intro_at','roles_intro_minutes','Roles intro + Word','mins', 8],
            ['table_topics_at','table_topics_minutes','Table Topics','mins', 25],
            ['break_at','break_minutes','Break','mins', 10], // sugerido, editable
            ['prepared_speeches_at','prepared_speeches_minutes','Prepared Speeches','mins', null], // variable
            ['general_evaluation_at','general_evaluation_minutes','General Evaluation','mins', null], // variable
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

        /* ---------------- Asignaciones (sugeridas pero editables) ----------------
           Estas NO son columnas de club_sessions. Las guardamos en
           session_functionary_role_assignments al guardar la sesión.
           Para las dos que vienen del comité (presidente y oficial de asambleas),
           si no las eliges, se consultan de club_officers y se guardan. */
        $assignFields = [
            // name del field => [etiqueta, role_code]
            'role_official_assembly'   => ['Official of Assembly (SAA)', 'sergeant_at_arms'],
            'role_president'           => ['President',                   'president'],
            'role_toastmaster'         => ['Toastmaster of the Day',      'toastmaster'],
            'role_general_evaluator'   => ['General Evaluator',           'general_evaluator'],
            'role_grammarian'          => ['Grammarian',                  'grammarian'],
            'role_ah_counter'          => ['Ah-Counter',                  'ah_counter'],
            'role_timer'               => ['Timer',                       'timer'],
        ];
        foreach ($assignFields as $name => [$label, $code]) {
            CRUD::addField([
                'name'      => $name,                     // campo "fake", no mapea a DB
                'type'      => 'relationship',            // select2 AJAX sobre Member
                'entity'    => 'members',                 // Backpack ignora, pero mantiene coherencia
                'model'     => \App\Models\Member::class, // para clarity
                'attribute' => 'name',
                'label'     => $label,
                'ajax'      => true,
                'minimum_input_length' => 1,
                'placeholder' => 'Selecciona (se sugiere automáticamente si lo dejas vacío)',
                'tab'       => 'Assignments',
                // Limitar miembros al club seleccionado (si ya se eligió)
                'options'   => function ($q) {
                    $clubId = request('club') ?? request('club_id');
                    return $clubId ? $q->where('club_id', $clubId)->orderBy('name') : $q->orderBy('name');
                },
            ]);
        }
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    /* -------------------------- STORE/UPDATE con sugerencias -------------------------- */

    public function store()
    {
        // 1) Completar defaults ANTES de validar (para que pase reglas como end_time after start_time)
        $this->applySessionDefaultsToRequest();

        // 2) Validar
        $this->crud->setRequest($this->crud->validateRequest());

        // 3) Crear sesión
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());

        // 4) Guardar asignaciones (usando sugeridos si no elegiste)
        $this->saveRoleAssignments($item->id, (int) $item->club_id);

        // 5) Responder
        \Alert::success('Session created.')->flash();
        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        // 1) Defaults (mismo criterio que store)
        $this->applySessionDefaultsToRequest();

        // 2) Validar
        $this->crud->setRequest($this->crud->validateRequest());

        // 3) Actualizar sesión
        $item = $this->crud->update($this->crud->getCurrentEntryId(), $this->crud->getStrippedSaveRequest());

        // 4) Reescribir asignaciones (idempotente)
        $this->saveRoleAssignments($item->id, (int) $item->club_id, replace: true);

        \Alert::success('Session updated.')->flash();
        return $this->crud->performSaveAction($item->getKey());
    }

    /* -------------------------- FETCH para el field "club" -------------------------- */
    public function fetchClub()
    {
        return $this->fetch(\App\Models\Club::class, ['id','name'], fn($q)=>$q->orderBy('name'));
    }

    /* ========================== Helpers internos ========================== */

    /**
     * Completa valores por defecto en el Request:
     * - fecha: próxima fecha del día de reunión del club (si está vacío)
     * - start_time: hora de reunión del club (si está vacío)
     * - end_time: start + 120 min (si está vacío)
     */
    protected function applySessionDefaultsToRequest(): void
    {
        $request = $this->crud->getRequest();
        $clubId = (int) ($request->input('club') ?? $request->input('club_id'));

        $club = $clubId ? \App\Models\Club::find($clubId) : null;

        // Fecha sugerida (próxima según meeting_day del club)
        $sessionDate = $request->input('session_date');
        if (!$sessionDate && $club && !empty($club->meeting_day)) {
            $sessionDate = $this->nextDateForWeekday($club->meeting_day);
        }

        // Start sugerido: hora de reunión del club
        $start = $request->input('start_time');
        if (!$start && $club && !empty($club->meeting_time)) {
            $start = $club->meeting_time; // 'H:i:s' o 'H:i'
        }

        // End sugerido: start + 120 min
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

        // Defaults de minutos si vienen vacíos
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
     * Guarda asignaciones en session_functionary_role_assignments.
     * Usa los campos del form si los elegiste; si no, sugiere desde el comité (club_officers).
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

        // Si replace, borra las anteriores de este set
        if ($replace) {
            DB::table('session_functionary_role_assignments')
                ->where('club_session_id', $clubSessionId)
                ->whereIn('role_code', array_values($map))
                ->delete();
        }

        $req = $this->crud->getRequest();

        foreach ($map as $field => $roleCode) {
            $memberId = $req->input($field);

            // Si no elegiste en el form, sugerimos desde el comité
            if (!$memberId) {
                // Sugerimos solo para presidente y SAA; el resto queda vacío si no elegiste
                if (in_array($roleCode, ['president','sergeant_at_arms'])) {
                    $memberId = $this->suggestOfficer($clubId, $roleCode);
                }
            }

            if ($memberId) {
                DB::table('session_functionary_role_assignments')->insert([
                    'club_session_id' => $clubSessionId,
                    'member_id'       => (int) $memberId,
                    'role_code'       => $roleCode,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }
    }

    /**
     * Busca el miembro vigente en el comité para un role_code dado.
     * Asume una tabla club_officers con: club_id, member_id, role_code, term_start, term_end, is_active.
     * Ajusta nombres de columnas si tu tabla difiere.
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
            ->where(function ($q) {
                // si tienes columna is_active = 1
                try { $q->where('is_active', 1); } catch (\Throwable $e) {}
            })
            ->orderByDesc('term_start')
            ->first();

        return $row?->member_id ? (int) $row->member_id : null;
    }

    /**
     * Devuelve la fecha próxima para un día de la semana.
     * Admite valores tipo 'Mon','Tue','Wed','Thu','Fri','Sat','Sun'
     * o en español 'Lun','Mar','Mié','Jue','Vie','Sáb','Dom'.
     */
    protected function nextDateForWeekday(string $day): string
    {
        $map = [
            'Mon'=>'monday','Tue'=>'tuesday','Wed'=>'wednesday','Thu'=>'thursday','Fri'=>'friday','Sat'=>'saturday','Sun'=>'sunday',
            'Lun'=>'monday','Mar'=>'tuesday','Mié'=>'wednesday','Jue'=>'thursday','Vie'=>'friday','Sáb'=>'saturday','Dom'=>'sunday',
        ];
        $norm = $map[$day] ?? strtolower($day);
        $date = Carbon::today();
        if ($date->englishDayOfWeek !== ucfirst($norm)) {
            $date = $date->next($norm);
        }
        return $date->toDateString();
    }
}
