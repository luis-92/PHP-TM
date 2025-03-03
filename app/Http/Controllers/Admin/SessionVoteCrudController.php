<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SessionVoteRequest;
use App\Models\SessionVote;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SessionVoteCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(SessionVote::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/session-vote');
        CRUD::setEntityNameStrings('Session Vote', 'Session Votes');
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
            'name' => 'voter_id',
            'label' => 'Voter',
            'type' => 'select',
            'entity' => 'voter',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addColumn([
            'name' => 'candidate_id',
            'label' => 'Candidate',
            'type' => 'select',
            'entity' => 'candidate',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addColumn([
            'name' => 'category',
            'label' => 'Category',
            'type' => 'text'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SessionVoteRequest::class);

        CRUD::addField([
            'name' => 'session_id',
            'label' => 'Session',
            'type' => 'select2',
            'entity' => 'session',
            'attribute' => 'session_date',
            'model' => "App\Models\ToastmastersSession"
        ]);

        CRUD::addField([
            'name' => 'voter_id',
            'label' => 'Voter',
            'type' => 'select2',
            'entity' => 'voter',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addField([
            'name' => 'candidate_id',
            'label' => 'Candidate',
            'type' => 'select2',
            'entity' => 'candidate',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addField([
            'name' => 'category',
            'label' => 'Category',
            'type' => 'text'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
