<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClubRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClubCrudController
 * @package App\Http\Controllers\Admin
 */
class ClubCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Club::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/club');
        CRUD::setEntityNameStrings('Club', 'Clubes');
    }

    /**
     * Define what happens when the List operation is loaded.
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Nombre');
        CRUD::column('description')->label('Descripción');
        CRUD::column('location')->label('Ubicación');
        CRUD::column('contact_email')->label('Email de Contacto');
        CRUD::column('logo')->type('image')->label('Logo');
        CRUD::column('active')->type('boolean')->label('Activo');
    }

    /**
     * Define what happens when the Create operation is loaded.
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClubRequest::class);

        CRUD::field('name')->label('Nombre')->type('text');
        CRUD::field('description')->label('Descripción')->type('textarea');
        CRUD::field('location')->label('Ubicación')->type('text');
        CRUD::field('contact_email')->label('Email de Contacto')->type('email');
        CRUD::field('logo')->label('Logo')->type('image')->crop(true)->aspect_ratio(1);
        CRUD::field('active')->label('Activo')->type('checkbox');
    }

    /**
     * Define what happens when the Update operation is loaded.
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
