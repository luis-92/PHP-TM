<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SpeechRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SpeechCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Speech::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/speech');
        CRUD::setEntityNameStrings('Discurso', 'Discursos');
    }

    protected function setupListOperation()
    {
        CRUD::column('member_id')->label('Miembro')->type('select')->entity('member')->model(\App\Models\Member::class)->attribute('first_name');
        CRUD::column('session_id')->label('Sesión')->type('select')->entity('session')->model(\App\Models\Session::class)->attribute('session_date');
        CRUD::column('title')->label('Título');
        CRUD::column('best_speech')->label('Mejor Discurso')->type('boolean');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SpeechRequest::class);

        CRUD::field('member_id')->label('Miembro')->type('select')->entity('member')->model(\App\Models\Member::class)->attribute('first_name');
        CRUD::field('session_id')->label('Sesión')->type('select')->entity('session')->model(\App\Models\Session::class)->attribute('session_date');
        CRUD::field('title')->label('Título')->type('text');
        CRUD::field('content')->label('Contenido')->type('textarea');
        CRUD::field('attachment')->label('Archivo')->type('upload')->disk('public');
        CRUD::field('best_speech')->label('Mejor Discurso')->type('checkbox');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
