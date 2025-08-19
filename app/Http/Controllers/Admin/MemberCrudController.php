<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

// Operaciones Backpack
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

// Para AJAX del relationship
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

/**
 * CRUD de Miembros para Backpack.
 * - Selector de Club por nombre (relationship + AJAX)
 * - Inline Create del Club (rutas definidas en ClubCrudController)
 * - Método fetchClub() para abastecer el selector
 */
class MemberCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;
    use FetchOperation; // solo fetch aquí

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Member::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/member');
        CRUD::setEntityNameStrings('member', 'members');

        // Evitar N+1 al listar
        CRUD::addClause('with', ['club:id,name']);
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumn([
            'name'      => 'club',
            'type'      => 'relationship',
            'label'     => 'Club',
            'attribute' => 'name',
        ]);

        CRUD::addColumn([
            'name'  => 'name',
            'type'  => 'text',
            'label' => 'Name',
        ]);

        CRUD::addColumn([
            'name'  => 'member_status',
            'type'  => 'boolean',
            'label' => 'Active?',
        ]);

        CRUD::addFilter([
            'type'  => 'select2',
            'name'  => 'club_id',
            'label' => 'Club',
        ],
        fn() => \App\Models\Club::orderBy('name')->pluck('name','id')->toArray(),
        fn($value) => CRUD::addClause('where', 'club_id', $value));
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(MemberRequest::class);

        // Campo "Club" con búsqueda AJAX + Inline Create (el modal usa las rutas del ClubCrudController)
        CRUD::addField([
            'name'        => 'club',
            'type'        => 'relationship',
            'label'       => 'Club',
            'attribute'   => 'name',
            'ajax'        => true,
            'minimum_input_length' => 2,
            'placeholder' => 'Busca por nombre o ciudad…',
            'inline_create' => [
                'entity' => 'club',
                'force_select' => true, // 👈 opcional
            ],
            'options'     => fn($q) => $q->orderBy('name'),
        ]);

        // Resto de campos
        CRUD::addField(['name' => 'name',            'type' => 'text',     'label' => 'Name']);
        CRUD::addField(['name' => 'first_lastname',  'type' => 'text',     'label' => 'First lastname']);
        CRUD::addField(['name' => 'second_lastname', 'type' => 'text',     'label' => 'Second lastname']);
        CRUD::addField(['name' => 'join_date',       'type' => 'date',     'label' => 'Join date']);
        CRUD::addField(['name' => 'member_status',   'type' => 'checkbox', 'label' => 'Active?']);
        CRUD::addField(['name' => 'member_level',    'type' => 'text',     'label' => 'Member level']);
        CRUD::addField(['name' => 'phone_number',    'type' => 'text',     'label' => 'Phone number']);

        CRUD::addField([
            'name'        => 'gender',
            'type'        => 'select_from_array',
            'label'       => 'Gender',
            'options'     => ['Male'=>'Male','Female'=>'Female','Other'=>'Other'],
            'allows_null' => true,
        ]);

        CRUD::addField(['name' => 'email',                   'type' => 'email', 'label' => 'Email']);
        CRUD::addField(['name' => 'address',                 'type' => 'text',  'label' => 'Address']);
        CRUD::addField(['name' => 'city',                    'type' => 'text',  'label' => 'City']);
        CRUD::addField(['name' => 'state',                   'type' => 'text',  'label' => 'State']);
        CRUD::addField(['name' => 'country',                 'type' => 'text',  'label' => 'Country']);
        CRUD::addField(['name' => 'emergency_contact_name',  'type' => 'text',  'label' => 'Emergency contact name']);
        CRUD::addField(['name' => 'emergency_contact_phone', 'type' => 'text',  'label' => 'Emergency contact phone']);
        CRUD::addField(['name' => 'professional_goals',      'type' => 'textarea', 'label' => 'Professional goals']);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    // Datos para el selector AJAX del campo "club"
    public function fetchClub()
    {
        return $this->fetch(\App\Models\Club::class, ['id','name'], function ($query) {
            $query->orderBy('name');
            // Aquí podrías limitar por permisos del usuario si aplica
        });
    }
}
