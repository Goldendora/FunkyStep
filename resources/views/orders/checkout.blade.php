@extends('layouts.app')

@section('content')
    @vite(['resources/css/cart.css'])

    <div class="cart-fullscreen container-fluid py-5">
        <div class="mx-auto form-box-funky p-5 rounded-4 shadow-lg" style="max-width: 900px;">
            <h2 class="fw-bold text-white text-center mb-4">Confirmar compra</h2>

            {{-- Tabla de productos --}}
            <div class="table-responsive rounded-4 overflow-hidden shadow-sm">
                <table class="table table-dark table-borderless align-middle text-center">
                    <thead class="table-header-funky">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="text-end mt-4">
                <h4 class="text-white">
                    Total a pagar:
                    <span class="text-white fw-bold">${{ number_format($total, 2) }}</span>
                </h4>
            </div>

            {{-- Botones de acción --}}
            <div class="mt-5">
                <form action="{{ route('checkout.pay') }}" method="POST" class="mb-3">
                    @csrf
                    <button class="btn btn-success w-100 py-3 fw-semibold rounded-3">
                        Pagar con tarjeta
                    </button>
                </form>

                <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100 py-3 fw-semibold rounded-3">
                    Cancelar compra
                </a>
            </div>
        </div>
    </div>
@endsection
