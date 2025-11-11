<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Stripe\Webhook;
use Stripe\Event;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET'); // lo defines en .env

        try {
            // Validar firma del evento con la clave secreta del webhook
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            return response('Firma inválida', 400);
        }

        // Solo nos interesa cuando Stripe confirma el pago
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $order = Order::where('payment_reference', $session->id)->first();

            if ($order && $order->status !== 'pagado') {
                DB::transaction(function () use ($order, $session) {
                    // Cambiar estado del pedido
                    $order->update([
                        'status' => 'pagado',
                        'raw_payload' => $session,
                    ]);

                    // Cargar carrito del usuario
                    $cart = CartItem::with('product')->where('user_id', $order->user_id)->get();

                    foreach ($cart as $item) {
                        // Crear registro en order_items
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'subtotal' => $item->price * $item->quantity,
                        ]);

                        // Actualizar stock y cantidad vendida
                        $product = $item->product;
                        $product->stock -= $item->quantity;
                        $product->sold_quantity += $item->quantity;
                        $product->save();
                    }

                    // Vaciar el carrito
                    CartItem::where('user_id', $order->user_id)->delete();
                });
            }
        }

        return response('Webhook recibido correctamente', 200);
    }
}
