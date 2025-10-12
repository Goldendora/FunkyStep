<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Mostrar los productos en el dashboard público (vista principal).
     */
    public function showPublic()
    {
        $products = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('dashboard', compact('products'));
    }

    /**
     * Mostrar listado de productos (solo para el panel admin).
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(15);
        return view('products.index', compact('products'));
    }

    /**
     * Mostrar formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guardar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'sku' => 'required|string|max:50|unique:products',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable', 
        ]);

        // Guardar imagen
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        // Marcar si está activo o no
        $validated['is_active'] = $request->has('is_active');

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Producto agregado correctamente.');
    }

    /**
     * Mostrar formulario de edición de producto.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable', 
        ]);

        // Si se sube una nueva imagen, reemplazar la anterior
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        // Marcar si está activo o no
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
