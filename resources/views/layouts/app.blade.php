<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funkystep - Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: #fff;
            padding-top: 1.5rem;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }

        .navbar {
            background-color: #212529;
        }

        .content-wrapper {
            margin-left: 240px;
            padding: 2rem;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    {{-- Navbar superior --}}
    <nav class="navbar navbar-dark shadow-sm px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Funkystep</a>

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
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Registrarse</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="d-flex">
        {{-- Sidebar (solo admin) --}}
        @auth
            @if(Auth::user()->role === 'admin')
                <div class="sidebar p-3">
                    <h5 class="text-center fw-bold mb-4">Panel Admin</h5>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard</a>
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        Usuarios</a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                        Productos</a>
                </div>
            @endif
        @endauth

        {{-- Contenido principal dinámico --}}
        <div class="content-wrapper w-100">
            {{-- Mensajes globales --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    {{-- Modal de edición de perfil (reutiliza el existente del dashboard) --}}
    @if(Auth::check())
        @include('partials.profile-modal')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @if(Auth::check())
        @include('partials.profile-modal')
    @endif

</body>

</html>