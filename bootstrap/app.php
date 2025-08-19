<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ 1) Alias para proteger /admin con tu middleware de admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckIfAdmin::class,
        ]);

        // ✅ 2) Grupo WEB COMPLETO (sesión + CSRF) requerido por Backpack
        $middleware->web(append: [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // (Opcional) Si usas API, aquí irían $middleware->api(...)
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
