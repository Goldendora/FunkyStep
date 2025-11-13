<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_puede_iniciar_sesion_con_credenciales_validas()
    {
        // 1️⃣ Crear usuario de prueba en la base temporal
        $user = User::factory()->create([
            'email' => 'test@funkystep.com',
            'password' => Hash::make('Password123!'),
        ]);

        // 2️⃣ Enviar solicitud POST al login
        $response = $this->post('/login', [
            'email' => 'test@funkystep.com',
            'password' => 'Password123!',
        ]);

        // 3️⃣ Verificar que redirige correctamente a la ruta de verificación 2FA
        $response->assertRedirect(route('verify.2fa'));

        // 4️⃣ Asegurar que el usuario está autenticado
        $this->assertAuthenticatedAs($user);
    }
}
