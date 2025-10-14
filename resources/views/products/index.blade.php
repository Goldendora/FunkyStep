@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Gestión de Productos</h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                Agregar Producto
            </a>
        </div>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tabla de productos --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped align-middle text-center">
                            <thead class="table-dark">
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
                                @foreach($products as $product)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $product->image
                                    ? asset('storage/' . $product->image)
                                    : 'https://via.placeholder.com/80' }}" alt="Imagen" class="rounded" width="70"
                                                            height="70">
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
                                                    <td>{{ $product->total_sales }}</td>
                                                    <td>
                                                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                            class="btn btn-sm btn-warning">Editar</a>

                                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('¿Eliminar este producto?')">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted m-0">No hay productos registrados todavía.</p>
                @endif
            </div>
        </div>
        <!-- Paginador -->
        @if ($products->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection