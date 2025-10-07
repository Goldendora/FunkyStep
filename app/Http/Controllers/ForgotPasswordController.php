<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Mostrar formulario para solicitar el enlace de recuperación
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Enviar enlace de recuperación al correo
    public function sendResetLinkEmail(Request $request)
    {
        // Validar el email
        $request->validate(['email' => 'required|email']);

        // Intentar enviar el enlace
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Verificar el resultado
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
