<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsuarioBaneado;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     */
    public function index()
    {
        // Cargar todos los usuarios junto con su baneo activo (si lo tienen)
        $users = User::with('baneoActivo')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Actualizar el rol de un usuario.
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Banear usuario (crear registro en usuarios_baneados)
     */
    public function ban(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:255',
            'duracion_dias' => 'nullable|integer|min:1',
        ]);

        $user = User::findOrFail($id);

        // Evitar que un admin se banee a sí mismo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes banearte a ti mismo.');
        }

        // Crear el registro de baneo
        UsuarioBaneado::create([
            'id_usuario' => $user->id,
            'motivo' => $request->motivo,
            'duracion_dias' => $request->duracion_dias ?: null,
            'baneado_por' => Auth::user()->name,
            'estado' => 'activo',
        ]);

        return back()->with('success', 'El usuario ha sido baneado correctamente.');
    }

    /**
     * ✅ Desbanear usuario (actualizar estado del baneo activo)
     */
    public function unban($id)
    {
        $baneo = UsuarioBaneado::where('id_usuario', $id)
            ->where('estado', 'activo')
            ->first();

        if ($baneo) {
            $baneo->update(['estado' => 'expirado']);
            return back()->with('success', 'El usuario ha sido desbaneado correctamente.');
        }

        return back()->with('error', 'El usuario no tiene baneos activos.');
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Si sube nueva foto
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');

            // Eliminar la anterior si existe
            if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
                \Storage::disk('public')->delete($user->profile_photo);
            }

            $validated['profile_photo'] = $path;
        }

        // Actualizar datos del usuario
        $user->update($validated);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }


}
