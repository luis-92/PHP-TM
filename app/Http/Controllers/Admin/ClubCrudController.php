<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClubRequest;
use App\Models\Club;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ClubCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(Club::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/club');
        CRUD::setEntityNameStrings('club', 'clubs');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'name', 'label' => 'Club Name', 'type' => 'text']);
        CRUD::addColumn(['name' => 'description', 'label' => 'Description', 'type' => 'textarea']);
        CRUD::addColumn(['name' => 'location', 'label' => 'Location', 'type' => 'text']);
        CRUD::addColumn(['name' => 'meeting_schedule', 'label' => 'Meeting Schedule', 'type' => 'text']);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClubRequest::class);

        CRUD::addField(['name' => 'name', 'label' => 'Club Name', 'type' => 'text']);
        CRUD::addField(['name' => 'description', 'label' => 'Description', 'type' => 'textarea']);
        CRUD::addField(['name' => 'location', 'label' => 'Location', 'type' => 'text']);
        CRUD::addField(['name' => 'meeting_schedule', 'label' => 'Meeting Schedule', 'type' => 'text']);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
