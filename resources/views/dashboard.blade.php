<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Funkystep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 shadow-sm">
        <a class="navbar-brand fw-bold" href="#">Funkystep</a>

        <div class="ms-auto d-flex align-items-center gap-2">
            {{-- Mostrar nombre del usuario si está logueado --}}
            @if(Auth::check())
                <span class="text-light me-2">👋 {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Registrarse</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
            @endif
        </div>
    </nav>

    {{-- Contenido principal --}}
    <div class="container mt-5">
        <div class="card shadow-lg p-5 border-0">
            <div class="text-center mb-4">
                <h2 class="fw-bold">
                    Bienvenido 
                    @if(Auth::check())
                        {{ Auth::user()->name }} 
                    @else
                        visitante 
                    @endif
                </h2>
                <p class="text-muted">Explora Funkystep y disfruta de tu experiencia.</p>
            </div>

            {{-- Mensaje general --}}
            @if(Auth::check())
                <p class="text-center fs-5">Has iniciado sesión correctamente </p>
            @else
                <p class="text-center fs-5">Regístrate o inicia sesión para acceder a todas las funciones.</p>
            @endif

            {{-- Botón visible solo para admin --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="text-center mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-primary px-4 py-2">
                         Gestionar Usuarios
                    </a>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
