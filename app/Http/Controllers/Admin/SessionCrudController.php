<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SessionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SessionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Session::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/session');
        CRUD::setEntityNameStrings('Sesión', 'Sesiones');
    }

    protected function setupListOperation()
    {
        CRUD::column('club_id')->label('Club')->type('select')->entity('club')->model(\App\Models\Club::class)->attribute('name');
        CRUD::column('session_date')->label('Fecha y Hora')->type('datetime');
        CRUD::column('agenda')->label('Agenda');
        CRUD::column('status')->label('Estado')->type('enum');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SessionRequest::class);

        CRUD::field('club_id')->label('Club')->type('select')->entity('club')->model(\App\Models\Club::class)->attribute('name');
        CRUD::field('session_date')->label('Fecha y Hora')->type('datetime_picker');
        CRUD::field('agenda')->label('Agenda')->type('textarea');
        CRUD::field('notes')->label('Notas')->type('textarea');
        CRUD::field('status')->label('Estado')->type('select_from_array')->options([
            'planned' => 'Planificada',
            'in_progress' => 'En curso',
            'completed' => 'Finalizada',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
