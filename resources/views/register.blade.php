<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - Funkystep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @vite(['resources/css/style.css'])
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

    <div class="card shadow p-4" style="width: 420px;">
        <h2 class="text-center mb-4">Crear cuenta</h2>

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
                    <li id="rule-length" class="text-danger"> Mínimo 8 caracteres</li>
                    <li id="rule-upper" class="text-danger"> Al menos una mayúscula (A-Z)</li>
                    <li id="rule-lower" class="text-danger"> Al menos una minúscula (a-z)</li>
                    <li id="rule-number" class="text-danger"> Al menos un número (0-9)</li>
                    <li id="rule-symbol" class="text-danger"> Al menos un símbolo (!@#$%)</li>
                </ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrarse</button>

            <p class="text-center mt-3 mb-0">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </form>
    </div>

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

                // Validaciones individuales
                const hasLength = value.length >= 8;
                const hasUpper = /[A-Z]/.test(value);
                const hasLower = /[a-z]/.test(value);
                const hasNumber = /\d/.test(value);
                const hasSymbol = /[\W_]/.test(value);

                // Actualiza visualmente cada regla
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


</body>

</html>