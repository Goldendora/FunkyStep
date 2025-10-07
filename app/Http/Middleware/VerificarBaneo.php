<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioBaneado;

class VerificarBaneo
{
    /**
     * Maneja la solicitud entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $baneoActivo = UsuarioBaneado::where('id_usuario', $user->id)
                ->where('estado', 'activo')
                ->first();

            if ($baneoActivo && $baneoActivo->estaActivo()) {
                // Cerrar sesión automáticamente
                Auth::logout();

                return redirect()->route('login')->withErrors([
                    'email' => 'Tu cuenta está suspendida. Motivo: ' . $baneoActivo->motivo,
                ]);
            }
        }

        return $next($request);
    }
}
