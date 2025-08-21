<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Client\PublicClubController;
use App\Http\Controllers\Client\PublicSessionController;
use App\Http\Controllers\Client\PublicSpeechRequestController;

// HOME: decide a dónde ir
Route::get('/', function () {
    return Auth::check()
        ? redirect()->to(backpack_url('dashboard'))
        : redirect()->to(backpack_url('login'));
})->name('home');

// Admin extra (protegido)
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => backpack_middleware(),
], function () {
    Route::get('reports/overview', [ReportsController::class, 'overview'])
        ->name('admin.reports.overview');
});

// Rutas públicas
Route::prefix('clubs')->group(function () {
    Route::get('/', [PublicClubController::class, 'index'])->name('public.clubs.index');
    Route::get('{club}', [PublicClubController::class, 'show'])->name('public.clubs.show');
    Route::get('{club}/sessions', [PublicSessionController::class, 'index'])->name('public.sessions.index');
});

Route::get('/sessions/{session}', [PublicSessionController::class, 'show'])->name('public.sessions.show');

Route::get('/sessions/{session}/request-speech', [PublicSpeechRequestController::class, 'create'])
    ->name('public.speech.request.create');

Route::post('/sessions/{session}/request-speech', [PublicSpeechRequestController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('public.speech.request.store');
