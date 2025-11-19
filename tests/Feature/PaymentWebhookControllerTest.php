<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;

class PaymentWebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function procesa_correctamente_un_webhook_checkout_session_completed()
    {
        // 1️⃣ Crear usuario, producto y pedido pendiente
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Zapatillas Funky Pro',
            'stock' => 5,
            'total_sales' => 0, // 👈 ahora usamos total_sales
            'price' => 200000,
        ]);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'pendiente',
            'total' => 200000,
            'payment_reference' => 'sess_test_123',
        ]);

        // 2️⃣ Agregar producto al carrito del usuario
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'price' => 200000,
            'quantity' => 2,
        ]);

        // 3️⃣ Simular el payload del webhook de Stripe
        $fakeSession = [
            'id' => 'sess_test_123',
            'object' => 'checkout.session',
            'payment_status' => 'paid',
            'amount_total' => 400000,
        ];

        // 4️⃣ Simular el evento Stripe (tipo checkout.session.completed)
        $event = [
            'id' => 'evt_123',
            'type' => 'checkout.session.completed',
            'data' => ['object' => $fakeSession],
        ];

        // 5️⃣ Enviar la petición simulada al endpoint del webhook
        $response = $this->postJson(route('stripe.webhook'), $event);

        // 6️⃣ Comprobar que el webhook respondió correctamente
        $response->assertStatus(200);
        $response->assertSee('Webhook recibido correctamente');

        // 7️⃣ Verificar que la orden cambió de estado
        $order->refresh();
        $this->assertEquals('pagado', $order->status);

        // 8️⃣ Verificar que se crearon los OrderItem
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // 9️⃣ Verificar que el stock y total_sales del producto se actualizaron correctamente
        $product->refresh();
        $this->assertEquals(3, $product->stock);
        $this->assertEquals(2, $product->total_sales); // 👈 antes era sold_quantity

        // 🔟 Verificar que el carrito del usuario fue vaciado
        $this->assertDatabaseMissing('cart_items', ['user_id' => $user->id]);
    }
}
