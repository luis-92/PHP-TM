<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClubCommitteeTitleRequest;
use App\Models\ClubCommitteeTitle;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ClubCommitteeTitleCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(ClubCommitteeTitle::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/club-committee-title');
        CRUD::setEntityNameStrings('Club Committee Title', 'Club Committee Titles');
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
            'name' => 'club_id',
            'label' => 'Club',
            'type' => 'select',
            'entity' => 'club',
            'attribute' => 'name',
            'model' => "App\Models\Club"
        ]);

        CRUD::addColumn([
            'name' => 'committee_title',
            'label' => 'Committee Title',
            'type' => 'enum'
        ]);

        CRUD::addColumn([
            'name' => 'start_date',
            'label' => 'Start Date',
            'type' => 'date'
        ]);

        CRUD::addColumn([
            'name' => 'end_date',
            'label' => 'End Date',
            'type' => 'date'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClubCommitteeTitleRequest::class);

        CRUD::addField([
            'name' => 'member_id',
            'label' => 'Member',
            'type' => 'select2',
            'entity' => 'member',
            'attribute' => 'id',
            'model' => "App\Models\Member"
        ]);

        CRUD::addField([
            'name' => 'club_id',
            'label' => 'Club',
            'type' => 'select2',
            'entity' => 'club',
            'attribute' => 'name',
            'model' => "App\Models\Club"
        ]);

        CRUD::addField([
            'name' => 'committee_title',
            'label' => 'Committee Title',
            'type' => 'select_from_array',
            'options' => [
                'president' => 'President',
                'assembly_officer' => 'Assembly Officer',
                'secretary' => 'Secretary',
                'vp_education' => 'VP Education',
                'vp_membership' => 'VP Membership',
                'treasurer' => 'Treasurer',
                'member' => 'Member',
            ],
            'allows_null' => false,
            'default' => 'member'
        ]);

        CRUD::addField([
            'name' => 'start_date',
            'label' => 'Start Date',
            'type' => 'date'
        ]);

        CRUD::addField([
            'name' => 'end_date',
            'label' => 'End Date',
            'type' => 'date'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
