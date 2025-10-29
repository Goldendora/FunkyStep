@extends('layouts.auth')

@section('title', 'Iniciar sesión - Funkystep')

@section('content')
    <h2 class="text-center mb-4 fw-bold">Iniciar sesión</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-gradient w-100 py-2 fw-bold">Ingresar</button>
    </form>

    <div class="d-flex justify-content-between mt-3 small">
        <a href="{{ route('register') }}">Crear cuenta</a>
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Continuar como invitado</a>
    </div>
@endsection
