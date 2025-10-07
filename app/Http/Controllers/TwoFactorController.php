<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class TwoFactorController extends Controller
{
    /**
     * Envía un nuevo código 2FA por correo
     */
    private function sendTwoFactorCode($user)
    {
        // Generar nuevo código
        $user->two_factor_code = rand(100000, 999999);
        $user->two_factor_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // Enviar correo con el código
        Mail::raw(
            "Hola {$user->name},\n\nTu código de verificación Funkystep es: {$user->two_factor_code}\n\nEste código expirará en 10 minutos.\n\nSi no solicitaste este código, puedes ignorar este mensaje.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Tu código de verificación - Funkystep');
            }
        );
    }

    /**
     * Muestra el formulario de verificación y envía el código automáticamente
     */
    public function showVerifyForm()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        //  Enviar siempre el código al entrar en la vista
        $this->sendTwoFactorCode($user);

        // Mensaje flash para que el usuario lo sepa
        session()->flash('success', 'Te enviamos un código de verificación a tu correo electrónico.');

        return view('auth.verify-2fa');
    }

    /**
     * Permite reenviar manualmente un código
     */
    public function sendCode()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $this->sendTwoFactorCode($user);

        return redirect()->route('verify.2fa')
                         ->with('success', 'Se envió un nuevo código de verificación a tu correo.');
    }

    /**
     * Verifica el código ingresado por el usuario
     */
    public function verify(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => 'required|numeric'
        ]);

        if (
            $user->two_factor_code == $request->code &&
            $user->two_factor_expires_at &&
            $user->two_factor_expires_at->isFuture()
        ) {
            // Limpiar el código una vez verificado
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();

            return redirect()->route('dashboard')
                             ->with('success', 'Verificación 2FA completada correctamente 🎉');
        }

        return back()->withErrors(['code' => 'Código incorrecto o expirado.']);
    }
}
