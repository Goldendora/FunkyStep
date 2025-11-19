<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminUpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Verifica que un administrador puede actualizar un producto existente.
     */
    public function un_administrador_puede_editar_un_producto_existente()
    {
        // 🧱 1️⃣ Simular el sistema de archivos
        Storage::fake('public');

        // 👑 2️⃣ Crear un admin autenticado
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // 📦 3️⃣ Crear un producto inicial
        $producto = Product::factory()->create([
            'name' => 'Zapatilla Original',
            'brand' => 'Funkystep',
            'category' => 'Zapatillas',
            'price' => 200000,
            'stock' => 15,
            'is_active' => true,
            'image' => 'product_images/old_image.jpg',
        ]);

        // 📸 4️⃣ Datos actualizados del producto
        $nuevaImagen = UploadedFile::fake()->image('nueva.jpg');
        $datosActualizados = [
            'name' => 'Zapatilla Edición Actualizada',
            'description' => 'Versión mejorada con nuevos materiales.',
            'price' => 210000,
            'stock' => 20,
            'category' => 'Zapatillas Urbanas',
            'brand' => 'Funkystep',
            'discount' => 5,
            'is_active' => true,
            'image' => $nuevaImagen,
        ];

        // 🚀 5️⃣ Enviar la solicitud PUT
        $response = $this->put(route('products.update', $producto->id), $datosActualizados);

        // ✅ 6️⃣ Debe redirigir correctamente al listado
        $response->assertRedirect(route('products.index'));

        // 💾 7️⃣ Verificar que la base se actualizó
        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'name' => 'Zapatilla Edición Actualizada',
            'price' => 210000,
            'stock' => 20,
            'category' => 'Zapatillas Urbanas',
            'discount' => 5,
            'brand' => 'Funkystep',
        ]);

        // 🖼️ 8️⃣ Asegurar que la nueva imagen fue guardada
        $productoRefrescado = Product::find($producto->id);
        Storage::disk('public')->assertExists($productoRefrescado->image);
    }

    /**
     * @test
     * Verifica que un usuario no admin no puede editar productos.
     */
    public function un_usuario_no_admin_no_puede_editar_productos()
    {
        // 1️⃣ Usuario normal
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        // 2️⃣ Producto existente
        $producto = Product::factory()->create([
            'name' => 'Producto Protegido',
            'price' => 100000,
        ]);

        // 3️⃣ Intento de modificación
        $data = [
            'name' => 'Intento No Autorizado',
            'price' => 120000,
        ];

        $response = $this->put(route('products.update', $producto->id), $data);

        // 🚫 4️⃣ Debe redirigir (no tiene permisos)
        $response->assertStatus(302);

        // 🚫 5️⃣ Verificar que el producto no cambió
        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'name' => 'Producto Protegido',
            'price' => 100000,
        ]);
    }
}
