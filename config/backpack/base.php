<?php

return [

    // Mostrar "Register" solo en local (como venía)
    'registration_open' => env('BACKPACK_REGISTRATION_OPEN', env('APP_ENV') === 'local'),

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */
    'route_prefix'   => 'admin',

    // El middleware web estándar
    'web_middleware' => 'web',
    // Si alguna vez necesitas la lista completa, puedes usar el array comentado del propio archivo.

    // Backpack registra sus rutas de auth / dashboard / account / password
    'setup_auth_routes'             => true,
    'setup_dashboard_routes'        => true,
    'setup_my_account_routes'       => true,
    'setup_password_recovery_routes'=> true,

    // Email verification (déjalo en false por ahora)
    'setup_email_verification_routes'     => false,
    'setup_email_verification_middleware' => true,
    'email_verification_throttle_access'  => '3,15',

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */
    'password_recovery_throttle_notifications' => 600, // seg
    'password_recovery_token_expiration'        => 60,  // min
    'password_recovery_throttle_access'         => '3,10',

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    // Modelo de usuario: toma el de config/auth.php
    'user_model_fqn' => config('auth.providers.users.model'),

    // ⚠️ Usa el middleware OFICIAL de Backpack para "admin"
    // (no el personalizado). Este middleware respetará el guard configurado abajo.
    'middleware_class' => [
        \Backpack\CRUD\app\Http\Middleware\CheckIfAdmin::class,
        \Backpack\CRUD\app\Http\Middleware\AuthenticateSession::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // \Backpack\CRUD\app\Http\Middleware\UseBackpackAuthGuardInsteadOfDefaultAuthGuard::class,
    ],

    // Clave de middleware (no tocar)
    'middleware_key' => 'admin',

    // Columna de autenticación
    'authentication_column'      => 'email',
    'authentication_column_name' => 'Email',
    'email_column'               => 'email',

    // ✅ CLAVE DEL ARREGLO: usa el MISMO guard que Laravel
    // para que auth()->check() y auth:web coincidan con el login de Backpack.
    'guard'     => 'web',
    // Password broker que corresponde al guard web (generalmente 'users')
    'passwords' => 'users',

    // Avatar
    'avatar_type'      => 'gravatar',
    'gravatar_fallback'=> 'blank',

    /*
    |--------------------------------------------------------------------------
    | File System
    |--------------------------------------------------------------------------
    */
    'root_disk_name' => 'root',

    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    */
    'useDatabaseTransactions' => false,

    /*
    |--------------------------------------------------------------------------
    | Backpack Token Username
    |--------------------------------------------------------------------------
    */
    'token_username' => env('BACKPACK_TOKEN_USERNAME', false),
];
