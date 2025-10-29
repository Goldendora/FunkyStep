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

<body class="bg-light">
    {{-- Navbar idéntica al dashboard --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 shadow-sm fixed-top">
        <div class="container-fluid">
            {{-- LOGO --}}
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('dashboard') }}">Funkystep</a>

            {{-- Botón responsive --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFunky"
                aria-controls="navbarFunky" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Contenido del Navbar --}}
            <div class="collapse navbar-collapse" id="navbarFunky">
                {{-- Menú central --}}
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-5">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold btn-funky" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold btn-funky" href="#collection">Collection</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold btn-funky" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold btn-funky" href="#contact">Contact</a>
                    </li>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link fw-semibold btn-funky">
                                Panel de usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link fw-semibold btn-funky">
                                Panel de productos
                            </a>
                        </li>
                    @endif
                </ul>

                {{-- Menú derecho --}}
                <div class="d-flex align-items-center gap-3">
                    @if(Auth::check())
                        {{-- 🛒 Carrito --}}
                        <div class="cart-btn me-2">
                            {{-- Botón para abrir el sidebar del carrito --}}
                            <button id="btnCarrito"
                                class="btn btn-funky position-relative d-flex align-items-center justify-content-center"
                                style="width:42px; height:38px;">
                                <i class="bi bi-bag fs-5"></i>

                                @php
                                    $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->count();
                                @endphp

                                @if($cartCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </button>
                        </div>


                        {{-- 👤 Menú de usuario --}}
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none btn-funky dropdown-toggle"
                                id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto de perfil"
                                        class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover;">
                                @else
                                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-secondary me-2"
                                        style="width: 38px; height: 38px;">
                                        <i class="bi bi-person text-white fs-5"></i>
                                    </div>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li class="dropdown-item text-center">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <p class="mb-0 small">{{ Auth::user()->email }}</p>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button type="button" class="btn-funky btn btn-sm w-100" data-bs-toggle="modal"
                                        data-bs-target="#photoModal">
                                        Editar perfil
                                    </button>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="text-center">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-1">
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        {{-- Invitado --}}
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="guestMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex justify-content-center align-items-center rounded-circle bg-secondary"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-white fs-5"></i>
                                </div>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestMenu">
                                <li>
                                    <a href="{{ route('register') }}" class="dropdown-item d-flex align-items-center gap-2">
                                        <i class="bi bi-person-plus"></i> Registrarse
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('login') }}" class="dropdown-item d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

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

    {{-- Modal de perfil --}}
    @if(Auth::check())
        @include('partials.profile-modal')
    @endif

    @if(Auth::check())
        @php
            $cartData = \App\Http\Controllers\CartController::getSidebarData();
        @endphp

        @include('partials.cart-sidebar', [
            'cartItems' => $cartData['cartItems'],
            'cartTotal' => $cartData['cartTotal']
        ])
    @endif

    {{-- Footer igual que el dashboard --}}
    <footer class="text-center small mt-5 mb-3 textoblanco">
        © {{ date('Y') }} Funkystep. Todos los derechos reservados.
    </footer>

    {{-- Filtro SVG decorativo (igual que dashboard) --}}
    <svg style="display: none">
        <filter id="glass-distortion" x="0%" y="0%" width="100%" height="100%" filterUnits="objectBoundingBox">
            <feTurbulence type="fractalNoise" baseFrequency="0.01 0.01" numOctaves="1" seed="5" result="turbulence" />
            <feComponentTransfer in="turbulence" result="mapped">
                <feFuncR type="gamma" amplitude="1" exponent="10" offset="0.5" />
                <feFuncG type="gamma" amplitude="0" exponent="1" offset="0" />
                <feFuncB type="gamma" amplitude="0" exponent="1" offset="0.5" />
            </feComponentTransfer>
            <feGaussianBlur in="turbulence" stdDeviation="3" result="softMap" />
            <feSpecularLighting in="softMap" surfaceScale="5" specularConstant="1" specularExponent="100"
                    lighting-color="white" result="specLight">
                <fePointLight x="-200" y="-200" z="300" />
            </feSpecularLighting>
    <feComposite in="specLight" operator="arithmetic" k1="0" k2="1" k3="1" k4="0" result="litImage" />
        <feDisplacementMap in="SourceGraphic" in2="softMap" scale="150" xChannelSelector="R" yChannelSelector="G" />
        </filter>
        </svg>
    </svg>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const openBtn = document.getElementById('btnCarrito');
            const sidebar = document.getElementById('cartSidebar');
            const closeBtn = document.getElementById('closeCartBtn');

            if (openBtn && sidebar) {
                openBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    sidebar.classList.add('open');
                });
            }

            if (closeBtn && sidebar) {
                closeBtn.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                });
            }
        });
    </script>
</body>

</html>
