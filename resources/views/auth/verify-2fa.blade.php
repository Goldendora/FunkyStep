<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación 2FA - Funkystep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

    <div class="card shadow p-4" style="width: 420px;">
        <h2 class="text-center mb-3 fw-bold text-dark">Verificación de seguridad</h2>

        {{-- Mensaje de éxito --}}
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
            <div class="mb-3">
                <label class="form-label fw-semibold">Código de correo</label>
                <input type="text" name="code" class="form-control text-center" maxlength="6" required autofocus>
            </div>

            <button type="submit" class="btn btn-success w-100 mb-2">Verificar código</button>
        </form>

        {{-- Reenviar código --}}
        <form method="POST" action="{{ route('verify.2fa.send') }}" class="text-center mt-2">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">Reenviar código</button>
        </form>

        {{-- Cancelar --}}
        <p class="text-center mt-3 mb-0">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-danger text-decoration-none">
               Cancelar verificación
            </a>
        </p>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

</body>
</html>
