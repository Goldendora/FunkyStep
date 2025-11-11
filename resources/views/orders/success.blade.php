@extends('layouts.app')

@section('content')
    @vite(['resources/css/cart.css'])

    <div class="cart-fullscreen container-fluid py-5">
        <div class="mx-auto form-box-funky p-5 rounded-4 shadow-lg text-center" style="max-width: 700px;">
            
            {{-- Ícono de éxito --}}
            <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" 
                 alt="Éxito" 
                 width="100" 
                 class="mb-3" 
                 style="filter: drop-shadow(0 0 8px rgba(60, 255, 100, 0.6));">

            {{-- Mensaje principal --}}
            <h2 class="text-success fw-bold mb-2">¡Pago completado con éxito!</h2>
            <p class="text-light mb-4">Tu pedido ha sido procesado correctamente. 🎉</p>

            {{-- Botones --}}
            <div class="d-flex flex-column gap-3 mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-success w-100 py-3 fw-semibold rounded-3">
                    Volver al catálogo
                </a>
                <a href="{{ route('cart.index') }}" class="btn btn-secondary w-100 py-3 fw-semibold rounded-3">
                    Ver carrito
                </a>
            </div>
        </div>

    </div>
@endsection
