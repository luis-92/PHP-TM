<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

// ⚠️ Usa el trait desde Backpack PRO
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;

class ClubCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;
    use InlineCreateOperation; // esto registra las rutas club-inline-*

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Club::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/club'); // /admin/club
        CRUD::setEntityNameStrings('club', 'clubs');
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Name']);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation([
            'name' => 'required|string|max:150',
        ]);

        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Name']);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
