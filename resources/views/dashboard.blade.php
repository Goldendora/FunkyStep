<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Funkystep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="#">Funkystep</a>
        <div class="ms-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2>Bienvenido al Dashboard 🎉</h2>
            <p>Has iniciado sesión correctamente.</p>

            {{-- Botón visible solo para admin --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">
                    👥 Gestionar Usuarios
                </a>
            @endif
        </div>
    </div>
</body>
</html>
