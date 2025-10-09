<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Funkystep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .profile-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #fff;
        }
    </style>
</head>

<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 shadow-sm">
        <a class="navbar-brand fw-bold" href="#">Funkystep</a>

        <div class="ms-auto d-flex align-items-center gap-3">
            @if(Auth::check())
                    {{-- Menú de usuario con foto --}}
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userMenu"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo
                ? asset('storage/' . Auth::user()->profile_photo)
                : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}" alt="Foto de perfil"
                                class="profile-img me-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                            <li class="dropdown-item text-center">
                                <strong>{{ Auth::user()->name }}</strong>
                                <p class="text-muted mb-0 small">{{ Auth::user()->email }}</p>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button type="button" class="dropdown-item text-center btn btn-outline-primary btn-sm w-100"
                                    data-bs-toggle="modal" data-bs-target="#photoModal">
                                    Editar perfil
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-1">Cerrar
                                        sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
            @else
                {{-- Si no está logueado --}}
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

            @if(Auth::check())
                <p class="text-center fs-5">Has iniciado sesión correctamente</p>
            @else
                <p class="text-center fs-5">Regístrate o inicia sesión para acceder a todas las funciones.</p>
            @endif

            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="text-center mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-primary px-4 py-2">
                         Gestionar Usuarios
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Catálogo público de productos --}}
    @if(isset($products) && count($products) > 0)
        <div class="container mt-5">
            <h3 class="fw-bold text-center mb-4">Catálogo de Zapatillas</h3>
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ $product->image
                    ? asset('storage/' . $product->image)
                    : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}"
                                style="height: 250px; object-fit: cover;">

                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                <p class="text-muted small mb-1">{{ $product->brand }}</p>
                                <p class="fw-bold text-success mb-1">
                                    ${{ number_format($product->final_price, 2) }}
                                </p>

                                @if($product->discount > 0)
                                    <p class="text-danger small mb-2">
                                        <del>${{ number_format($product->price, 2) }}</del>
                                        -{{ $product->discount }}%
                                    </p>
                                @endif

                                @if($product->stock > 0)
                                    <button class="btn btn-outline-primary btn-sm w-100">
                                        Agregar al carrito
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center text-muted mt-5">
            <p>No hay productos disponibles en este momento.</p>
        </div>
    @endif

    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="container text-end my-4">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Agregar Producto</a>
        </div>
    @endif

    {{--  Modal de perfil incluido desde partials --}}
    @if(Auth::check())
        @include('partials.profile-modal')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
