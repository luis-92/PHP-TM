<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberEvaluationRequest;
use App\Models\MemberEvaluation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class MemberEvaluationCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(MemberEvaluation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member-evaluation');
        CRUD::setEntityNameStrings('Member Evaluation', 'Member Evaluations');
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
            'name' => 'member_id',
            'label' => 'Evaluated Member',
            'type' => 'select',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member"
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
            'name' => 'evaluation_type',
            'label' => 'Evaluation Type',
            'type' => 'enum'
        ]);

        CRUD::addColumn([
            'name' => 'clarity',
            'label' => 'Clarity',
            'type' => 'number'
        ]);

        CRUD::addColumn([
            'name' => 'feedback',
            'label' => 'Feedback',
            'type' => 'textarea'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(MemberEvaluationRequest::class);

        CRUD::addField([
            'name' => 'session_id',
            'label' => 'Session',
            'type' => 'select2',
            'entity' => 'session',
            'attribute' => 'session_date',
            'model' => "App\Models\ToastmastersSession"
        ]);

        CRUD::addField([
            'name' => 'member_id',
            'label' => 'Evaluated Member',
            'type' => 'select2',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member"
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
            'name' => 'evaluation_type',
            'label' => 'Evaluation Type',
            'type' => 'select_from_array',
            'options' => [
                'prepared_speech' => 'Prepared Speech',
                'table_topic_speech' => 'Table Topic Speech',
            ],
            'allows_null' => false
        ]);

        CRUD::addField([
            'name' => 'clarity',
            'label' => 'Clarity',
            'type' => 'number',
            'attributes' => ["min" => 1, "max" => 5]
        ]);

        CRUD::addField([
            'name' => 'vocal_variety',
            'label' => 'Vocal Variety',
            'type' => 'number',
            'attributes' => ["min" => 1, "max" => 5]
        ]);

        CRUD::addField([
            'name' => 'feedback',
            'label' => 'Feedback',
            'type' => 'textarea'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
