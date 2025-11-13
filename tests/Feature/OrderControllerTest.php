<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function calcula_correctamente_el_total_del_carrito_en_el_checkout()
    {
        // 1️⃣ Crear usuario autenticado
        $user = User::factory()->create([
            'email' => 'checkout@funkystep.com',
            'password' => Hash::make('Password123!')
        ]);
        $this->actingAs($user);

        // 2️⃣ Crear productos con precios simulados
        $producto1 = Product::factory()->create([
            'name' => 'Zapatillas Funky Pro',
            'price' => 200000,
            'discount' => 0,
        ]);

        $producto2 = Product::factory()->create([
            'name' => 'Funky Street',
            'price' => 150000,
            'discount' => 10, // 10% de descuento
        ]);

        // 3️⃣ Agregar productos al carrito
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $producto1->id,
            'price' => $producto1->price,
            'quantity' => 2,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $producto2->id,
            // Aplicar descuento manual al guardarlo
            'price' => $producto2->price - ($producto2->price * 0.10),
            'quantity' => 1,
        ]);

        // 4️⃣ Ejecutar el método checkout (simulando visita a la ruta)
        $response = $this->get(route('checkout'));

        // 5️⃣ Calcular el total esperado manualmente
        $esperado = (200000 * 2) + (150000 * 0.90 * 1); // 200000x2 + 135000 = 535000

        // 6️⃣ Comprobar que la vista se renderiza correctamente
        $response->assertStatus(200);
        $response->assertViewIs('orders.checkout');
        $response->assertViewHas('total', $esperado);
    }

    /** @test */
    public function redirige_si_el_carrito_esta_vacio()
    {
        // Crear usuario sin carrito
        $user = User::factory()->create();
        $this->actingAs($user);

        // Llamar a la ruta
        $response = $this->get(route('checkout'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error', 'Tu carrito está vacío.');
    }
}
