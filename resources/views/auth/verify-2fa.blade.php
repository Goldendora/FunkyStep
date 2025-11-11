@extends('layouts.auth')

@section('title', 'Verificación 2FA - Funkystep')

@section('content')
    <h2 class="text-center mb-4 fw-bold">Verificación de seguridad</h2>

    {{-- Mensaje de éxito o instrucciones --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @else
        <p class="text-center text-muted">
            Ingresa el código de 6 dígitos que enviamos a tu correo electrónico.
        </p>
    @endif

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de verificación --}}
    <form method="POST" action="{{ route('verify.2fa.post') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold">Código de verificación</label>
            <input type="text"
                   name="code"
                   maxlength="6"
                   class="form-control text-center fs-4 fw-bold"
                   placeholder="••••••"
                   inputmode="numeric"
                   required
                   autofocus>
        </div>

        {{-- ✅ Botón animado Funkystep --}}
        <div class="super-button-container">
            <button type="submit" class="super-button">
                <span>Verificar código</span>
                <svg fill="none" viewBox="0 0 24 24" class="arrow">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor"
                        d="M5 12h14M13 6l6 6-6 6"></path>
                </svg>
            </button>
        </div>
    </form>

    {{-- Reenviar código --}}
    <form method="POST" action="{{ route('verify.2fa.send') }}" class="text-center mt-3">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none fw-semibold text-light">
            <i class="bi bi-arrow-repeat me-1"></i> Reenviar código
        </button>
    </form>

    {{-- Cancelar verificación --}}
    <p class="text-center mt-4 mb-0">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="text-danger fw-semibold text-decoration-none">
           <i class="bi bi-x-circle me-1"></i> Cancelar verificación
        </a>
    </p>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@endsection
