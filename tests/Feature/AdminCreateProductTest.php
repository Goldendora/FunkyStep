<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCreateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Verifica que un administrador puede registrar un nuevo producto exitosamente.
     */
    public function un_administrador_puede_registrar_un_nuevo_producto()
    {
        // 🧱 1️⃣ Simulamos almacenamiento de archivos
        Storage::fake('public');

        // 👑 2️⃣ Creamos un usuario administrador autenticado
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // 📦 3️⃣ Datos del nuevo producto
        $data = [
            'name' => 'Zapatillas Funky Test',
            'description' => 'Zapatillas de prueba edición limitada.',
            'price' => 250000,
            'stock' => 10,
            'category' => 'Zapatillas',
            'brand' => 'Funkystep',
            'sku' => 'SKU12345',
            'discount' => 10,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('zapatilla.jpg'),
        ];

        // 🚀 4️⃣ Hacemos la petición POST al endpoint de creación
        $response = $this->post(route('products.store'), $data);

        // ✅ 5️⃣ Verificamos que redirige correctamente
        $response->assertRedirect(route('products.index'));

        // 💾 6️⃣ Verificamos que el producto se guardó en la base de datos
        $this->assertDatabaseHas('products', [
            'name' => 'Zapatillas Funky Test',
            'brand' => 'Funkystep',
            'category' => 'Zapatillas',
            'price' => 250000,
            'stock' => 10,
            'is_active' => 1,
        ]);

        // 🖼️ 7️⃣ Comprobamos que la imagen se guardó en el almacenamiento
        $product = Product::first();
        Storage::disk('public')->assertExists($product->image);
    }

    /**
     * @test
     * Verifica que un usuario no administrador no puede acceder a la ruta de creación.
     */
    public function un_usuario_no_admin_no_puede_registrar_productos()
    {
        // 1️⃣ Creamos un usuario con rol "user" (no admin)
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        // 2️⃣ Datos básicos del producto que intenta registrar
        $data = [
            'name' => 'Producto no autorizado',
            'price' => 100000,
            'stock' => 5,
            'sku' => 'NOADMIN123',
        ];

        // 3️⃣ Ejecutamos la solicitud POST a la ruta protegida
        $response = $this->post(route('products.store'), $data);

        // 4️⃣ Verificamos que fue redirigido (middleware devolvió 302)
        $response->assertStatus(302);

        // 5️⃣ (Opcional) Si redirige al dashboard o login, puedes validarlo
        // $response->assertRedirect(route('dashboard'));

        // 6️⃣ Comprobamos que el producto no se haya guardado en la base
        $this->assertDatabaseMissing('products', ['sku' => 'NOADMIN123']);
    }
}
