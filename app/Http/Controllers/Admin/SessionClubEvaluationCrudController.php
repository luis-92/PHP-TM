<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SessionClubEvaluationRequest;
use App\Models\SessionClubEvaluation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SessionClubEvaluationCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(SessionClubEvaluation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/session-club-evaluation');
        CRUD::setEntityNameStrings('Session Club Evaluation', 'Session Club Evaluations');
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
            'name' => 'evaluator_id',
            'label' => 'Evaluator',
            'type' => 'select',
            'entity' => 'evaluator',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addColumn([
            'name' => 'comments',
            'label' => 'Comments',
            'type' => 'textarea'
        ]);

        CRUD::addColumn([
            'name' => 'rating',
            'label' => 'Rating',
            'type' => 'number'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SessionClubEvaluationRequest::class);

        CRUD::addField([
            'name' => 'session_id',
            'label' => 'Session',
            'type' => 'select2',
            'entity' => 'session',
            'attribute' => 'session_date',
            'model' => "App\Models\ToastmastersSession"
        ]);

        CRUD::addField([
            'name' => 'evaluator_id',
            'label' => 'Evaluator',
            'type' => 'select2',
            'entity' => 'evaluator',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addField([
            'name' => 'comments',
            'label' => 'Comments',
            'type' => 'textarea'
        ]);

        CRUD::addField([
            'name' => 'rating',
            'label' => 'Rating',
            'type' => 'number',
            'attributes' => ["min" => 1, "max" => 5]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

