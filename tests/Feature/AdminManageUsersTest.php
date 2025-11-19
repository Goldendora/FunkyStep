<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UsuarioBaneado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminManageUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Verifica que el administrador puede ver la lista de usuarios.
     */
    public function un_administrador_puede_ver_la_lista_de_usuarios()
    {
        // 👑 1️⃣ Crear admin y usuarios
        $admin = User::factory()->create(['role' => 'admin']);
        $users = User::factory(3)->create();

        // 2️⃣ Autenticar admin
        $this->actingAs($admin);

        // 3️⃣ Llamar a la vista
        $response = $this->get(route('users.index'));

        // ✅ 4️⃣ Verificamos que muestra la lista
        $response->assertStatus(200);
        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    /**
     * @test
     * Verifica que el administrador puede cambiar el rol de un usuario.
     */
    public function un_administrador_puede_actualizar_el_rol_de_un_usuario()
    {
        // 1️⃣ Admin y usuario normal
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        // 2️⃣ Autenticar admin
        $this->actingAs($admin);

        // 3️⃣ Enviar actualización de rol
        $response = $this->put(route('users.updateRole', $user->id), [
            'role' => 'admin',
        ]);

        // ✅ 4️⃣ Verificar respuesta
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'admin',
        ]);
    }

    /**
     * @test
     * Verifica que un administrador puede banear y desbanear usuarios.
     */
    public function un_administrador_puede_banear_y_desbanear_usuarios()
    {
        // 1️⃣ Admin y usuario
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin);

        // 2️⃣ Banear usuario
        $response = $this->post(route('users.ban', $user->id), [
            'motivo' => 'Incumplimiento de normas',
            'duracion_dias' => 3,
        ]);

        // ✅ 3️⃣ Verificar que se creó el baneo
        $response->assertRedirect();
        $this->assertDatabaseHas('usuario_baneados', [
            'id_usuario' => $user->id,
            'estado' => 'activo',
        ]);

        // 4️⃣ Desbanear
        $baneo = UsuarioBaneado::where('id_usuario', $user->id)->first();
        $response2 = $this->post(route('users.unban', $user->id));

        // ✅ 5️⃣ Verificar que se cambió el estado
        $response2->assertRedirect();
        $this->assertDatabaseHas('usuario_baneados', [
            'id' => $baneo->id,
            'estado' => 'expirado',
        ]);
    }

    /**
     * @test
     * Verifica que un usuario normal NO puede gestionar roles ni baneos.
     */
    public function un_usuario_no_admin_no_puede_gestionar_usuarios()
    {
        // 1️⃣ Usuario sin permisos
        $user = User::factory()->create(['role' => 'user']);
        $otro = User::factory()->create();

        $this->actingAs($user);

        // 🚫 Intentar cambiar rol
        $response = $this->put(route('users.updateRole', $otro->id), ['role' => 'admin']);
        $response->assertStatus(302);

        // 🚫 Intentar banear
        $response2 = $this->post(route('users.ban', $otro->id), ['motivo' => 'spam']);
        $response2->assertStatus(302);

        // 🚫 Intentar ver listado
        $response3 = $this->get(route('users.index'));
        $response3->assertStatus(302);
    }
}
