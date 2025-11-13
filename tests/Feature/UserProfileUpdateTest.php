<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  Verifica que un usuario autenticado puede actualizar su perfil correctamente.
     */
    public function test_usuario_puede_actualizar_sus_datos_personales(): void
    {
        // 🧩 1️⃣ Simulamos almacenamiento público
        Storage::fake('public');

        // 🧩 2️⃣ Creamos un usuario autenticado
        $user = User::factory()->create();

        // 🧩 3️⃣ Nueva foto de perfil simulada
        $nuevaFoto = UploadedFile::fake()->image('foto_nueva.png');

        // 🧩 4️⃣ Nuevos datos a enviar
        $data = [
            'address' => 'Calle 123',
            'city' => 'Medellín',
            'postal_code' => '050001',
            'phone_number' => '3001234567',
            'profile_photo' => $nuevaFoto,
        ];

        // 🧩 5️⃣ Realizamos la solicitud autenticada
        $response = $this->actingAs($user)->post(route('profile.update'), $data);

        // 🧩 6️⃣ Validamos redirección exitosa
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Perfil actualizado correctamente.');

        // 🧩 7️⃣ Verificamos que la imagen se guardó
        Storage::disk('public')->assertExists('profile_photos/' . $nuevaFoto->hashName());

        // 🧩 8️⃣ Refrescamos el usuario desde la BD
        $user->refresh();

        // 🧩 9️⃣ Confirmamos que los datos se actualizaron correctamente
        $this->assertEquals('Calle 123', $user->address);
        $this->assertEquals('Medellín', $user->city);
        $this->assertEquals('050001', $user->postal_code);
        $this->assertEquals('3001234567', $user->phone_number);
        $this->assertNotNull($user->profile_photo);
    }

    /**
     *  Verifica que un usuario no autenticado NO pueda actualizar su perfil.
     */
    public function test_usuario_no_autenticado_no_puede_actualizar_perfil(): void
    {
        // 1️⃣ Simulamos petición sin autenticación
        $response = $this->post(route('profile.update'), [
            'address' => 'Intento sin login'
        ]);

        // 2️⃣ Debe redirigir al login
        $response->assertRedirect(route('login'));
    }
}
