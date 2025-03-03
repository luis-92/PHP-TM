<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExperiencedMemberRequest;
use App\Models\ExperiencedMember;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ExperiencedMemberCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(ExperiencedMember::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/experienced-member');
        CRUD::setEntityNameStrings('Experienced Member', 'Experienced Members');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'member_id',
            'label' => 'Member',
            'type' => 'select',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addColumn([
            'name' => 'years_of_experience',
            'label' => 'Years of Experience',
            'type' => 'number'
        ]);

        CRUD::addColumn([
            'name' => 'speeches_given',
            'label' => 'Speeches Given',
            'type' => 'number'
        ]);

        CRUD::addColumn([
            'name' => 'awards_won',
            'label' => 'Awards Won',
            'type' => 'number'
        ]);

        CRUD::addColumn([
            'name' => 'certifications',
            'label' => 'Certifications',
            'type' => 'textarea'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ExperiencedMemberRequest::class);

        CRUD::addField([
            'name' => 'member_id',
            'label' => 'Member',
            'type' => 'select2',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member",
            'allows_null' => false
        ]);

        CRUD::addField([
            'name' => 'years_of_experience',
            'label' => 'Years of Experience',
            'type' => 'number',
            'attributes' => ["min" => 0]
        ]);

        CRUD::addField([
            'name' => 'speeches_given',
            'label' => 'Speeches Given',
            'type' => 'number',
            'attributes' => ["min" => 0]
        ]);

        CRUD::addField([
            'name' => 'awards_won',
            'label' => 'Awards Won',
            'type' => 'number',
            'attributes' => ["min" => 0]
        ]);

        CRUD::addField([
            'name' => 'certifications',
            'label' => 'Certifications',
            'type' => 'textarea'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
