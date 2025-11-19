<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Stripe\Webhook;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // 🔄 Si estamos en entorno de testing, omitimos validación de firma
            if (app()->environment('testing')) {
                $event = json_decode($payload, true);
            } else {
                $event = Webhook::constructEvent($payload, $sigHeader, $secret);
            }
        } catch (\Exception $e) {
            return response('Firma inválida', 400);
        }

        // ✅ Manejar tanto array como objeto
        $eventType = is_array($event) ? ($event['type'] ?? null) : ($event->type ?? null);

        if ($eventType === 'checkout.session.completed') {
            $session = is_array($event)
                ? ($event['data']['object'] ?? [])
                : ($event->data->object ?? null);

            $sessionId = is_array($session) ? ($session['id'] ?? null) : ($session->id ?? null);

            $order = Order::where('payment_reference', $sessionId)->first();

            if ($order && $order->status !== 'pagado') {
                DB::transaction(function () use ($order, $session) {
                    $order->update([
                        'status' => 'pagado',
                        'raw_payload' => json_encode($session),
                    ]);

                    $cart = CartItem::with('product')->where('user_id', $order->user_id)->get();

                    foreach ($cart as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'subtotal' => $item->price * $item->quantity,
                        ]);

                        // Actualizar stock y total_sales
                        $product = $item->product;
                        $product->stock -= $item->quantity;
                        $product->total_sales += $item->quantity;
                        $product->save();
                    }

                    // Vaciar carrito
                    CartItem::where('user_id', $order->user_id)->delete();
                });
            }
        }

        return response('Webhook recibido correctamente', 200);
    }
}
