<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SessionRoleRequest;
use App\Models\SessionRole;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SessionRoleCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(SessionRole::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/session-role');
        CRUD::setEntityNameStrings('Session Role', 'Session Roles');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'session_id',
            'label' => 'Session',
            'type' => 'select',
            'entity' => 'session',
            'attribute' => 'session_date',
            'model' => "App\Models\ToastmastersSession"
        ]);

        CRUD::addColumn([
            'name' => 'role',
            'label' => 'Role',
            'type' => 'enum'
        ]);

        CRUD::addColumn([
            'name' => 'member_id',
            'label' => 'Assigned Member',
            'type' => 'select',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addColumn([
            'name' => 'substitute_member_id',
            'label' => 'Substitute Member',
            'type' => 'select',
            'entity' => 'substituteMember',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addColumn([
            'name' => 'replacement_member_id',
            'label' => 'Replacement Member',
            'type' => 'select',
            'entity' => 'replacementMember',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SessionRoleRequest::class);

        CRUD::addField([
            'name' => 'session_id',
            'label' => 'Session',
            'type' => 'select2',
            'entity' => 'session',
            'attribute' => 'session_date',
            'model' => "App\Models\ToastmastersSession"
        ]);

        CRUD::addField([
            'name' => 'role',
            'label' => 'Role',
            'type' => 'select_from_array',
            'options' => [
                'grammarian' => 'Grammarian',
                'timer' => 'Timer',
                'ah-counter' => 'Ah-Counter',
                'general_evaluator' => 'General Evaluator',
                'speech_evaluator' => 'Speech Evaluator',
            ],
            'allows_null' => false
        ]);

        CRUD::addField([
            'name' => 'member_id',
            'label' => 'Assigned Member',
            'type' => 'select2',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addField([
            'name' => 'substitute_member_id',
            'label' => 'Substitute Member',
            'type' => 'select2',
            'entity' => 'substituteMember',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addField([
            'name' => 'replacement_member_id',
            'label' => 'Replacement Member',
            'type' => 'select2',
            'entity' => 'replacementMember',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
