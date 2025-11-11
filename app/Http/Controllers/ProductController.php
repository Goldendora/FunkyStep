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
        $banerproducts = Product::whereIn('id', [1, 21, 20]) // solo esos IDs
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get(); // no uses paginate si son pocos

        return view('dashboard', compact('banerproducts'));
    }
    /**
     * Mostrar el catálogo completo de productos activos (público).
     */
    /**
     * Mostrar el catálogo completo de productos activos con filtros y búsqueda.
     */
    public function showCatalog(Request $request)
    {
        // Iniciamos la query base: solo productos activos
        $query = Product::where('is_active', true);

        // --- FILTROS DINÁMICOS ---
        // Búsqueda por nombre o descripción
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por marca
        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        // Filtro por categoría
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Filtro por rango de precios
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // --- EJECUTAR CONSULTA ---
        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Obtener marcas y categorías únicas para los selectores
        $brands = Product::where('is_active', true)->distinct()->pluck('brand')->filter();
        $categories = Product::where('is_active', true)->distinct()->pluck('category')->filter();

        return view('catalog.index', compact('products', 'brands', 'categories'));
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
