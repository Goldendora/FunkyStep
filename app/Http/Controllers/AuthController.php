<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioBaneado;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        // Validamos los datos enviados
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos autenticar con las credenciales
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // regenerar sesión

            //  Verificación de baneo antes de permitir acceso
            $user = Auth::user();

            // Buscar si existe un baneo activo
            $baneoActivo = UsuarioBaneado::where('id_usuario', $user->id)
                ->where('estado', 'activo')
                ->first();

            if ($baneoActivo) {
                // Si el baneo sigue vigente, bloquear el acceso
                if ($baneoActivo->estaActivo()) {
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'email' => 'Tu cuenta está suspendida. Motivo: ' . $baneoActivo->motivo,
                    ]);
                } else {
                    // Si el baneo ya expiró, se actualiza su estado automáticamente
                    $baneoActivo->update(['estado' => 'expirado']);
                }
            }

            // generar nuevo código 2FA en cada inicio de sesión
            $user->two_factor_code = rand(100000, 999999);
            $user->two_factor_expires_at = now()->addMinutes(10);
            $user->save();

            // Redirigir a la verificación 2FA
            return redirect()->route('verify.2fa');
        }

        // Si falla, devolvemos al login con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Si hay un usuario, limpiamos el código 2FA por seguridad
        if ($user) {
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), //Encriptacion de contraseña
        ]);

        // Generar código 2FA aleatorio de 6 dígitos
        $code = rand(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        // Iniciar sesión temporalmente (pero sin acceso al dashboard aún)
        Auth::login($user);

        // Redirigir a la vista de verificación del código
        return redirect()->route('verify.2fa');
    }
}
