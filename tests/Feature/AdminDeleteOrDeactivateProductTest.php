<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDeleteOrDeactivateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Verifica que un administrador puede eliminar un producto existente.
     */
    public function un_administrador_puede_eliminar_un_producto()
    {
        // 🧱 1️⃣ Simular almacenamiento
        Storage::fake('public');

        // 👑 2️⃣ Crear un admin autenticado
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // 📦 3️⃣ Crear un producto con imagen
        $producto = Product::factory()->create([
            'name' => 'Producto a Eliminar',
            'image' => 'product_images/ejemplo.png',
            'is_active' => true,
        ]);

        // 🚀 4️⃣ El admin ejecuta la eliminación
        $response = $this->delete(route('products.destroy', $producto->id));

        // ✅ 5️⃣ Verificamos redirección al listado
        $response->assertRedirect(route('products.index'));

        // 💾 6️⃣ Verificar que el producto fue eliminado
        $this->assertDatabaseMissing('products', ['id' => $producto->id]);

        // 🖼️ 7️⃣ Comprobamos que la imagen fue eliminada
        Storage::disk('public')->assertMissing('product_images/ejemplo.png');
    }

    /**
     * @test
     * Verifica que un administrador puede desactivar un producto sin eliminarlo.
     */
    public function un_administrador_puede_desactivar_un_producto()
    {
        // 1️⃣ Admin autenticado
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // 2️⃣ Producto activo
        $producto = Product::factory()->create([
            'name' => 'Producto Desactivable',
            'is_active' => true,
        ]);

        // 3️⃣ Actualizamos el estado (simula desactivación)
        $response = $this->put(route('products.update', $producto->id), [
            'name' => $producto->name,
            'price' => $producto->price,
            'stock' => $producto->stock,
            'brand' => $producto->brand,
            'category' => $producto->category,
            'discount' => $producto->discount,
            'is_active' => false, // 🚫 desactivado
        ]);

        // 4️⃣ Redirige correctamente
        $response->assertRedirect(route('products.index'));

        // 5️⃣ Verificamos que el campo se actualizó
        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'is_active' => 0,
        ]);
    }

    /**
     * @test
     * Verifica que un usuario no admin no puede eliminar productos.
     */
    public function un_usuario_no_admin_no_puede_eliminar_productos()
    {
        // 1️⃣ Usuario normal
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        // 2️⃣ Producto existente
        $producto = Product::factory()->create(['name' => 'Producto Protegido']);

        // 3️⃣ Intento de eliminación
        $response = $this->delete(route('products.destroy', $producto->id));

        // 🚫 4️⃣ Middleware redirige (302)
        $response->assertStatus(302);

        // 🚫 5️⃣ El producto sigue en la base
        $this->assertDatabaseHas('products', ['id' => $producto->id]);
    }
}
