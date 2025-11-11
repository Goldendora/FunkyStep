<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Funkystep</title>
    @vite(['resources/css/app.css', 'resources/css/cart.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo/funky.png') }}">

    <!-- Fuente principal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
</head>

<body class="bg-light">
    {{-- Navbar --}}
    <x-navbar />
    {{-- Contenido principal --}}
    <x-hero />
    {{-- Catálogo público de productos --}}

    <div class="container-fluid px-5 mt-5">
        <div class="content textoblanco">
            <h1 class="title">
                Estos son nuestros productos más vendidos
            </h1>
            <p class="subtitle">Si lo piensas, lo encuentras en FunkyStep</p>
        </div>
        <x-catalogo :products="$banerproducts" />
    </div>


    <x-footer />

</html>