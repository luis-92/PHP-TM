<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class MemberCrudController extends CrudController
{
    public function setup()
    {
        CRUD::setModel(Member::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member');
        CRUD::setEntityNameStrings('member', 'members');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'user_id',
            'label' => 'User',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'email',
            'model' => "App\Models\User"
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
            'name' => 'join_date',
            'label' => 'Join Date',
            'type' => 'date'
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(MemberRequest::class);

        CRUD::addField([
            'name' => 'user_id',
            'label' => 'User',
            'type' => 'select2',
            'entity' => 'user',
            'attribute' => 'email',
            'model' => "App\Models\User"
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
            'name' => 'join_date',
            'label' => 'Join Date',
            'type' => 'date'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
