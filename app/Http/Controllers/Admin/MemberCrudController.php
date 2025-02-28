<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class MemberCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Member::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member');
        CRUD::setEntityNameStrings('Miembro', 'Miembros');
    }

    protected function setupListOperation()
    {
        CRUD::column('first_name')->label('Nombre');
        CRUD::column('last_name')->label('Apellido');
        CRUD::column('email')->label('Correo Electrónico');
        CRUD::column('phone_number')->label('Teléfono');
        CRUD::column('role')->label('Rol');
        CRUD::column('photo')->type('image')->label('Foto');
        CRUD::column('active')->type('boolean')->label('Activo');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(MemberRequest::class);

        CRUD::field('club_id')->label('Club')->type('select')->entity('club')->model(\App\Models\Club::class)->attribute('name');
        CRUD::field('first_name')->label('Nombre')->type('text');
        CRUD::field('last_name')->label('Apellido')->type('text');
        CRUD::field('email')->label('Correo Electrónico')->type('email');
        CRUD::field('phone_number')->label('Teléfono')->type('text');
        CRUD::field('role')->label('Rol')->type('text');
        CRUD::field('photo')->label('Foto')->type('image')->crop(true)->aspect_ratio(1);
        CRUD::field('active')->label('Activo')->type('checkbox');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
