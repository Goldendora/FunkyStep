@extends('layouts.auth')

@section('title', 'Crear cuenta - Funkystep')

@section('content')
    <h2 class="text-center mb-4 fw-bold">Crear cuenta</h2>

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

    {{-- Formulario de registro --}}
    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <ul class="mt-2 small list-unstyled" id="password-rules">
                <li id="rule-length" class="text-danger">⬜ Mínimo 8 caracteres</li>
                <li id="rule-upper" class="text-danger">⬜ Al menos una mayúscula (A-Z)</li>
                <li id="rule-lower" class="text-danger">⬜ Al menos una minúscula (a-z)</li>
                <li id="rule-number" class="text-danger">⬜ Al menos un número (0-9)</li>
                <li id="rule-symbol" class="text-danger">⬜ Al menos un símbolo (!@#$%)</li>
            </ul>
        </div>

        <div class="mb-4">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        {{-- ✅ Botón centralizado igual que el login --}}
        <div class="super-button-container">
            <button type="submit" class="super-button">
                <span>Registrarse</span>
                <svg fill="none" viewBox="0 0 24 24" class="arrow">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor"
                        d="M5 12h14M13 6l6 6-6 6"></path>
                </svg>
            </button>
        </div>

        <p class="text-center mt-4 small">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="fw-semibold text-light text-decoration-none">Inicia sesión</a>
        </p>
    </form>

    {{-- Script de validación de contraseña --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const rules = {
                length: document.getElementById('rule-length'),
                upper: document.getElementById('rule-upper'),
                lower: document.getElementById('rule-lower'),
                number: document.getElementById('rule-number'),
                symbol: document.getElementById('rule-symbol')
            };

            passwordInput.addEventListener('input', () => {
                const value = passwordInput.value;

                const hasLength = value.length >= 8;
                const hasUpper = /[A-Z]/.test(value);
                const hasLower = /[a-z]/.test(value);
                const hasNumber = /\d/.test(value);
                const hasSymbol = /[\W_]/.test(value);

                toggleRule(rules.length, hasLength);
                toggleRule(rules.upper, hasUpper);
                toggleRule(rules.lower, hasLower);
                toggleRule(rules.number, hasNumber);
                toggleRule(rules.symbol, hasSymbol);
            });

            function toggleRule(element, isValid) {
                if (isValid) {
                    element.classList.remove('text-danger');
                    element.classList.add('text-success');
                    element.textContent = element.textContent.replace('⬜', '🟩');
                } else {
                    element.classList.remove('text-success');
                    element.classList.add('text-danger');
                    element.textContent = element.textContent.replace('🟩', '⬜');
                }
            }
        });
    </script>
@endsection
