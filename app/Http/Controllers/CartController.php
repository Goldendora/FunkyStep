<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Mostrar el carrito del usuario autenticado.
     */
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Total calculado con descuentos
        $total = $items->sum(function ($item) {
            $precioConDescuento = $item->product->price - ($item->product->price * ($item->product->discount / 100));
            return $precioConDescuento * $item->quantity;
        });

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Agregar un producto al carrito.
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if (!$product->is_active || $product->stock < 1) {
            return back()->with('error', 'Este producto no está disponible.');
        }

        // Calcular precio con descuento actual
        $precioConDescuento = $product->price - ($product->price * ($product->discount / 100));

        // Buscar o crear el ítem del carrito
        $cartItem = CartItem::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['price' => $precioConDescuento]
        );

        // Si ya existía, solo aumentamos la cantidad
        if (!$cartItem->wasRecentlyCreated) {
            $cartItem->increment('quantity');
        }

        return back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualizar la cantidad de un producto en el carrito.
     */
    public function update(Request $request, $id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Actualizar cantidad
        $item->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cantidad actualizada.');
    }

    /**
     * Eliminar un producto del carrito.
     */
    public function remove($id)
    {
        CartItem::where('user_id', Auth::id())->where('id', $id)->delete();

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vaciar todo el carrito del usuario.
     */
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Carrito vaciado.');
    }

    public static function getSidebarData()
    {
        if (!Auth::check()) {
            return ['cartItems' => collect(), 'cartTotal' => 0];
        }

        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum(function ($item) {
            $precioConDescuento = $item->product->price - ($item->product->price * ($item->product->discount / 100));
            return $precioConDescuento * $item->quantity;
        });

        return ['cartItems' => $items, 'cartTotal' => $total];
    }
}
