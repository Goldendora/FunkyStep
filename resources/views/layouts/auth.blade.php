<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autenticación - Funkystep')</title>

    @vite(['resources/css/auth.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="auth-body d-flex">

    {{-- Sección izquierda: imagen o fondo decorativo --}}
    <section class="auth-left">
        <img src="{{ asset('images/auth/shoes/1.png') }}" alt="Zapatilla" class="auth-img">
        <div class="overlay">
            <div class="bars">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <h1 class="funky-title">FUNKYSTEP</h1>
        </div>
    </section>

    {{-- Sección derecha: contenido dinámico (login, register, etc.) --}}
    <section class="auth-right d-flex align-items-center justify-content-center">
        <div class="auth-card p-5 shadow-lg">
            @yield('content')
        </div>
    </section>

</body>

</html>