@extends('layouts.app')

@section('content')
    @vite(['resources/css/table.css'])

    {{-- 🔹 Tabla fullscreen Funkystep --}}
    <table class="tabla-fullscreen" role="grid">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            Agregar Producto
        </a>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Stock</th>
                <th>Ventas</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    {{-- Imagen del producto --}}
                    <td class="foto-perfil">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80' }}"
                            alt="Imagen de {{ $product->name }}" class="profile-img rounded">
                    </td>

                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand ?? '-' }}</td>
                    <td>{{ $product->category ?? '-' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->discount > 0)
                            <span class="text-success fw-bold">{{ $product->discount }}%</span>
                        @else
                            <span class="text-muted">0%</span>
                        @endif
                    </td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->sold_quantity ?? 0 }}</td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="acciones">
                        {{-- Editar --}}
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        {{-- Eliminar --}}
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar este producto?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-5">
                        No hay productos registrados todavía.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginador --}}
    @if ($products->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->onEachSide(1)->links('pagination::funkystep') }}
        </div>
    @endif
@endsection