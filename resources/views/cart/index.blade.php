@extends('layouts.app')

@section('content')
    @vite(['resources/css/cart.css'])

    <div class="cart-fullscreen container-fluid py-5">
        <h2 class="fw-bold text-white text-center mb-4">Mi carrito</h2>

        {{-- Mensajes de sesión --}}
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if($items->isEmpty())
            <div class="empty-cart">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Carrito vacío">
                <h5 class="mt-3 text-white">Tu carrito está vacío.</h5>
                <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Explorar productos</a>
            </div>
        @else
            <div class="table-responsive rounded-4 overflow-hidden shadow-sm">
                <table class="table table-dark table-borderless align-middle text-center">
                    <thead class="table-header-funky">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                {{-- Producto --}}
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             alt="{{ $item->product->name }}"
                                             class="product-img me-3">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-white">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->product->brand }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Precio --}}
                                <td>${{ number_format($item->price, 2) }}</td>

                                {{-- Cantidad --}}
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            class="form-control d-inline w-50 text-center bg-dark text-white border-secondary">
                                        <button class="btn btn-sm btn-outline-info mt-2">Actualizar</button>
                                    </form>
                                </td>

                                {{-- Total --}}
                                <td class="fw-bold text-success">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>

                                {{-- Eliminar --}}
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar este producto del carrito?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total y acciones --}}
            <div class="row mt-5 justify-content-center">
                <div class="col-md-5">
                    <form action="{{ route('cart.clear') }}" method="POST"
                          onsubmit="return confirm('¿Vaciar el carrito completo?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-warning w-100 fw-bold">Vaciar carrito</button>
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="total-box p-4 rounded-4 text-center">
                        <h5 class="text-white mb-2">Total a pagar:</h5>
                        <h2 class="fw-bold text-success mb-3">${{ number_format($total, 2) }}</h2>
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100 py-2 fw-semibold">
                            Proceder al pago
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
