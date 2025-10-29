@extends('layouts.auth')

@section('title', 'Recuperar contraseña - Funkystep')

@section('content')
    <h2 class="text-center mb-4 fw-bold">Recuperar contraseña</h2>

    {{-- Mostrar mensaje de estado --}}
    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
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

    {{-- Formulario para pedir el enlace --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold">Correo electrónico</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="Ingresa tu correo registrado"
                   required
                   autofocus>
        </div>

        {{-- ✅ Botón animado coherente con login y register --}}
        <div class="super-button-container">
            <button type="submit" class="super-button">
                <span>Enviar enlace</span>
                <svg fill="none" viewBox="0 0 24 24" class="arrow">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor"
                        d="M5 12h14M13 6l6 6-6 6"></path>
                </svg>
            </button>
        </div>

        <p class="text-center mt-4 small">
            <a href="{{ route('login') }}" class="text-light text-decoration-none fw-semibold">
                <i class="bi bi-box-arrow-in-left me-1"></i> Volver al inicio de sesión
            </a>
        </p>
    </form>
@endsection
