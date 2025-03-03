<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ToastmastersSessionRequest;
use App\Models\ToastmastersSession;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ToastmastersSessionCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(ToastmastersSession::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/toastmasters-session');
        CRUD::setEntityNameStrings('Toastmasters Session', 'Toastmasters Sessions');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'club_id',
            'label' => 'Club',
            'type' => 'select',
            'entity' => 'club',
            'attribute' => 'name',
            'model' => "App\Models\Club"
        ]);

        CRUD::addColumn([
            'name' => 'session_date',
            'label' => 'Session Date',
            'type' => 'datetime'
        ]);

        CRUD::addColumn([
            'name' => 'agenda',
            'label' => 'Agenda',
            'type' => 'textarea'
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'enum'
        ]);

        CRUD::addColumn([
            'name' => 'duration',
            'label' => 'Duration (minutes)',
            'type' => 'number'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ToastmastersSessionRequest::class);

        CRUD::addField([
            'name' => 'club_id',
            'label' => 'Club',
            'type' => 'select2',
            'entity' => 'club',
            'attribute' => 'name',
            'model' => "App\Models\Club"
        ]);

        CRUD::addField([
            'name' => 'session_date',
            'label' => 'Session Date',
            'type' => 'datetime_picker'
        ]);

        CRUD::addField([
            'name' => 'agenda',
            'label' => 'Agenda',
            'type' => 'textarea'
        ]);

        CRUD::addField([
            'name' => 'notes',
            'label' => 'Notes',
            'type' => 'textarea'
        ]);

        CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'planned' => 'Planned',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
            ],
            'allows_null' => false,
            'default' => 'planned'
        ]);

        CRUD::addField([
            'name' => 'duration',
            'label' => 'Duration (minutes)',
            'type' => 'number'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
