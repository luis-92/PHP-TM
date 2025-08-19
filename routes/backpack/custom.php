<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\\Http\\Controllers\\Admin',
], function () {
    Route::crud('attendance', 'AttendanceCrudController');
    Route::crud('club', 'ClubCrudController');
    Route::crud('clubsession', 'ClubSessionCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('sessionfunctionaryroleassignment', 'SessionFunctionaryRoleAssignmentCrudController');
    Route::crud('speech', 'SpeechCrudController');
    Route::crud('tabletopic', 'TableTopicCrudController');
    Route::crud('visitor', 'VisitorCrudController');
});
