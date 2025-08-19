<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Admin\ReportsController;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    Route::get('reports/overview', [ReportsController::class, 'overview'])->name('admin.reports.overview');
});

use App\Http\Controllers\Client\PublicClubController;
use App\Http\Controllers\Client\PublicSessionController;
use App\Http\Controllers\Client\PublicSpeechRequestController;

Route::prefix('clubs')->group(function () {
    Route::get('/', [PublicClubController::class, 'index'])->name('public.clubs.index');
    Route::get('{club}', [PublicClubController::class, 'show'])->name('public.clubs.show');
    Route::get('{club}/sessions', [PublicSessionController::class, 'index'])->name('public.sessions.index');
});

// Agenda pública de una sesión
Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('public.sessions.show');

// Solicitud pública para dar un discurso (con rate limit)
Route::get('/sessions/{session}/request-speech', [PublicSpeechRequestController::class, 'create'])->name('public.speech.request.create');
Route::post('/sessions/{session}/request-speech', [PublicSpeechRequestController::class, 'store'])
    ->middleware('throttle:10,1') // 10 req/min por IP (anti-spam)
    ->name('public.speech.request.store');

