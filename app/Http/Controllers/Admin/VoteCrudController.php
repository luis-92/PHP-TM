<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VoteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class VoteCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Vote::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vote');
        CRUD::setEntityNameStrings('Voto', 'Votaciones');
    }

    protected function setupListOperation()
    {
        CRUD::column('session_id')->label('Sesión')->type('select')->entity('session')->model(\App\Models\Session::class)->attribute('session_date');
        CRUD::column('member_id')->label('Miembro')->type('select')->entity('member')->model(\App\Models\Member::class)->attribute('first_name');
        CRUD::column('category')->label('Categoría');
        CRUD::column('nominee_id')->label('Nominado')->type('select')->entity('nominee')->model(\App\Models\Member::class)->attribute('first_name');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VoteRequest::class);

        CRUD::field('session_id')->label('Sesión')->type('select')->entity('session')->model(\App\Models\Session::class)->attribute('session_date');
        CRUD::field('member_id')->label('Miembro')->type('select')->entity('member')->model(\App\Models\Member::class)->attribute('first_name');
        CRUD::field('category')->label('Categoría')->type('text');
        CRUD::field('nominee_id')->label('Nominado')->type('select')->entity('nominee')->model(\App\Models\Member::class)->attribute('first_name');
        CRUD::field('reason')->label('Razón')->type('textarea');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
