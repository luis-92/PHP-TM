<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('club', 'ClubCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('session', 'SessionCrudController');
    Route::crud('speech', 'SpeechCrudController');
    Route::crud('session-role', 'SessionRoleCrudController');
    Route::crud('evaluation', 'EvaluationCrudController');
    Route::crud('vote', 'VoteCrudController');
    Route::crud('toastmasters-session', 'ToastmastersSessionCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
