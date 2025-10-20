<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Mostrar resumen del carrito antes de pagar
     */
    public function checkout()
    {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total en COP
        $total = $cart->sum(fn($item) => $item->price * $item->quantity);

        return view('orders.checkout', compact('cart', 'total'));
    }

    /**
     * Crear la sesión de pago con Stripe (con conversión COP -> USD)
     */
    public function createStripeSession(Request $request)
    {
        $user = Auth::user();

        // Cargar carrito actual
        $cart = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total en COP
        $totalCop = $cart->sum(fn($i) => $i->price * $i->quantity);

        // Crear orden pendiente en DB (total guardado en COP)
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $totalCop,
            'status' => 'pendiente',
            'payment_method' => 'stripe',
            'payment_provider' => 'stripe',
        ]);

        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // 🔄 Tasa de conversión COP -> USD (puedes ajustar o automatizar más adelante)
        $conversionRate = 4000; // 1 USD = 4000 COP (ejemplo)
        $lineItems = [];

        // Construir los productos para Stripe
        foreach ($cart as $item) {
            // Convertir el precio de COP a USD
            $usdPrice = $item->price / $conversionRate;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    // Stripe requiere los valores en CENTAVOS de USD
                    'unit_amount' => intval(round($usdPrice * 100)),
                ],
                'quantity' => $item->quantity,
            ];
        }

        // Crear sesión de pago en Stripe
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index'),
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'currency_conversion' => 'COP->USD',
                'rate' => $conversionRate,
            ],
        ]);

        // Guardar referencia del pago en la orden
        $order->update(['payment_reference' => $session->id]);

        // Redirigir al checkout de Stripe
        return redirect($session->url);
    }

    /**
     * Vista de éxito tras pago
     */
    public function success()
    {
        return view('orders.success');
    }
}
