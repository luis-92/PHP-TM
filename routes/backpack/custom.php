<?php

use Illuminate\Support\Facades\Route;

// Auth (override)
use App\Http\Controllers\Auth\LoginController as AppLogin;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttendanceCrudController;
use App\Http\Controllers\Admin\ClubCrudController;
use App\Http\Controllers\Admin\ClubSessionCrudController;
use App\Http\Controllers\Admin\MemberCrudController;
use App\Http\Controllers\Admin\SessionFunctionaryRoleAssignmentCrudController;
use App\Http\Controllers\Admin\SpeechCrudController;
use App\Http\Controllers\Admin\TableTopicCrudController;
use App\Http\Controllers\Admin\VisitorCrudController;

/**
 * A) LOGIN / LOGOUT (solo 'web')  → público
 */
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web'],  // 👈 sin 'admin', sin 'auth'
], function () {
    Route::get('login',  [AppLogin::class, 'showLoginForm'])->name('backpack.auth.login');
    Route::post('login', [AppLogin::class, 'login']);
    Route::post('logout', [AppLogin::class, 'logout'])->name('backpack.auth.logout');
});

/**
 * B) HOME y DASHBOARD (autenticado, SIN 'admin')
 *    Evita que el CheckIfAdmin te devuelva al login mientras no tengas roles.
 */
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'auth'],
], function () {
    // /admin -> /admin/dashboard
    Route::get('/', fn () => redirect()->route('backpack.dashboard'))->name('backpack.home');

    // /admin/dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('backpack.dashboard');
});

/**
 * C) CRUDs y resto del panel (protegido por 'admin')
 */
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => backpack_middleware(), // = ['web','admin']
], function () {
    Route::crud('attendance', AttendanceCrudController::class);
    Route::crud('club', ClubCrudController::class);
    Route::crud('clubsession', ClubSessionCrudController::class);
    Route::crud('member', MemberCrudController::class);
    Route::crud('sessionfunctionaryroleassignment', SessionFunctionaryRoleAssignmentCrudController::class);
    Route::crud('speech', SpeechCrudController::class);
    Route::crud('tabletopic', TableTopicCrudController::class);
    Route::crud('visitor', VisitorCrudController::class);
});
