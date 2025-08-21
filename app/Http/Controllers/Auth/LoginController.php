<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Backpack\CRUD\app\Http\Controllers\Auth\LoginController as BackpackLoginController;

class LoginController extends BackpackLoginController
{
    /** Destino después de login */
    protected function redirectTo(): string
    {
        return backpack_url('dashboard'); // /admin/dashboard
    }

    /** Ignora intended y manda siempre al dashboard (evita loops con /admin) */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        return redirect()->to(backpack_url('dashboard'));
    }

    /** Tras logout vuelve al login admin */
    protected function loggedOut(Request $request): RedirectResponse
    {
        return redirect()->to(backpack_url('login'));
    }
}
