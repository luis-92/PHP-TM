<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

class DashboardController extends CrudController
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
