<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Funkystep</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/cart.css'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo/funky.png') }}">


    <!-- Fuente principal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
</head>

     <x-chatbot />

<body class="bg-light" >

    <x-navbar />
    {{-- Contenido principal dinámico --}}
    <main class="container-fluid px-5 min-vh-100 d-flex flex-column justify-content-start"
        style="margin-top: 120px; padding-bottom: 120px;">
        {{-- Alertas globales --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Sección dinámica --}}
        @yield('content')
    </main>

    <x-footer />
</body>

<!-- AOS Animations -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        offset: 100,
        easing: 'ease-in-out',
        once: true
    });
</script>


</html>