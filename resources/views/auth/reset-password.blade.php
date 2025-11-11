@extends('layouts.auth')

@section('title', 'Restablecer contraseña - Funkystep')

@section('content')
    <h2 class="text-center mb-4 fw-bold">Restablecer contraseña</h2>

    {{-- Mostrar mensajes --}}
    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de nueva contraseña --}}
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label class="form-label fw-semibold">Nueva contraseña</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Ingresa una nueva contraseña"
                   required
                   autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Confirmar contraseña</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Repite la nueva contraseña"
                   required>
        </div>

        {{-- ✅ Botón Funkystep coherente con todo el sistema --}}
        <div class="super-button-container">
            <button type="submit" class="super-button">
                <span>Actualizar contraseña</span>
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
