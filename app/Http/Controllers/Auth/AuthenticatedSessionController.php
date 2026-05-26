<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Rules\HCaptchaRule;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar login con hCaptcha
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //  Validación de credenciales + CAPTCHA (Rule)
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'h-captcha-response' => ['required', new HCaptchaRule()],
        ]);

        //  Autenticación Laravel
        $request->authenticate();

        //  Seguridad de sesión
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}