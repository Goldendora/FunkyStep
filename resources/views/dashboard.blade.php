<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Funkystep</title>
    @vite(['resources/css/app.css', 'resources/css/cart.css','resources/js/app.js'])

    <!-- Fuente principal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">
</head>

<body class="bg-light">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 shadow-sm fixed-top">
        <div class="container-fluid">
            {{-- LOGO --}}
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('dashboard') }}">Funkystep</a>

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

    {{-- Contenido principal --}}
    <main class="hero">
        <div class="container-fluid px-5 hero-grid">
            {{-- Texto principal --}}
            <section aria-labelledby="hero-title">
                <p class="tag">NIKE AIR MAX 90</p>
                <h1 id="hero-title" class="title">AIR MAX</h1>
                <h2 class="subtitle">NIKE AIR MAX 90</h2>
                <p class="price">$160.000</p>
                <p class="desc">
                    <span class="cursor line1">Nothing as fly, nothing as comfortable, nothing as proven —</span>
                    <span class="cursor line2">the NIKE AIR MAX 90 stays true to level.</span>
                </p>

                @auth
                    <form action="{{ route('cart.add', 22) }}" method="POST">
                        @csrf
                        <button type="submit" class="cta d-inline-flex align-items-center gap-2">
                            AGREGAR AL CARRITO
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="cta d-inline-flex align-items-center gap-2 text-decoration-none">
                        INICIAR SESIÓN PARA COMPRAR
                    </a>
                @endauth
            </section>

            {{-- Imagen principal --}}
            <section class="visual" aria-label="Vista del producto">
                <img src="{{ Vite::asset('public/images/ofer/image.png') }}"
                    alt="Zapatilla Nike Air Max 90 en gris y negro" />

                {{-- Burbujas decorativas (mantengo clases b1..b6) --}}
                <div class="bubble-wrap b1"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b2"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b3"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b4"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b5"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b6"><span class="bubble" aria-hidden="true"></span></div>
            </section>

            {{-- Imagen decorativa secundaria --}}
            <section class="visual2-wrap" aria-label="Vista del producto">
                <img id="visual2" src="{{ Vite::asset('public/images/decoration/image1.png') }}"
                    alt="Zapatilla Nike Air Max 90 en gris y negro" class="visual2" />
            </section>
            <section class="visual2-wrap" aria-label="Vista del producto">
                <img src="{{ Vite::asset('public\images\decoration\HallowenBaner.png') }}"
                    alt="Zapatilla Nike Air Max 90 en gris y negro" class="visual2" />
            </section>
        </div>
    </main>

    {{-- Catálogo público de productos --}}
    @if(isset($products) && count($products) > 0)
        <div class="container-fluid px-5 mt-5">
            <div class="content textoblanco">
                <h1 class="title">
                    Estos son nuestros productos mas vendidos
                    <div class="aurora">
                        <div class="aurora__item"></div>
                        <div class="aurora__item"></div>
                        <div class="aurora__item"></div>
                        <div class="aurora__item"></div>
                    </div>
                </h1>
                <p class="subtitle">Si lo piensas, lo encuentras en FunkyStep</p>
            </div>
            <div class="catalogo">
                @foreach($products as $product)
                    <div class="product">
                        <span class="product__price">
                            ${{ number_format($product->price - ($product->price * ($product->discount / 100)), 0, ',', '.') }}
                        </span>

                        <img class="product__image"
                            src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}"
                            alt="{{ $product->name }}">

                        <span class="product__category">{{ $product->brand }}</span>
                        <h1 class="product__title">{{ $product->name }}</h1>
                        <hr>

                        <p class="desc">{{ Str::limit($product->description, 120) }}</p>

                        @if($product->stock > 0)
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="product__btn">Agregar</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="product__btn text-decoration-none">Login</a>
                            @endauth
                        @else
                            <button class="product__btn" disabled>Agotado</button>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Paginador --}}
            @if ($products->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->onEachSide(1)->links('pagination::funkystep') }}
                </div>
            @endif
        </div>
        {{-- Modal de producto (se mantiene dentro del archivo) --}}
        <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    {{-- Encabezado del modal --}}
                    <div class="modal-header border-0 bg-gradient text-white py-3 px-4">
                        <h4 class="modal-title fw-bold" id="modalTitle"></h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    {{-- Cuerpo --}}
                    <div class="modal-body p-0 bg-light">
                        <div class="row g-0 align-items-stretch">
                            {{-- Imagen --}}
                            <div class="col-md-6 d-flex align-items-center justify-content-center bg-white p-4">
                                <img id="modalImage" class="img-fluid rounded-3 shadow-sm"
                                    style="max-height: 450px; object-fit: cover;" alt="Producto">
                            </div>

                            {{-- Información --}}
                            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                                <h3 class="fw-bold mb-3 text-dark" id="modalName"></h3>
                                <p id="modalBrand" class="fw-semibold text-muted mb-1"></p>
                                <p id="modalCategory" class="text-secondary small mb-2"></p>
                                <p id="modalDescription" class="text-dark mb-3 lh-base"></p>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <p id="modalPrice" class="fw-bold fs-3 text-primary mb-0"></p>
                                        <p id="modalDiscount" class="text-danger small mb-0"></p>
                                        <p id="modalStock" class="text-muted small mb-0"></p>
                                    </div>
                                </div>

                                @if($product->stock > 0)
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-gradient btn-lg rounded-pill w-100 mt-3 fw-semibold">
                                                Agregar al carrito
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm w-100">
                                            Inicia sesión para comprar
                                        </a>
                                    @endauth
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>Agotado</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center text-muted mt-5">
            <p>No hay productos disponibles en este momento.</p>
        </div>
    @endif

    {{-- Modal de perfil (se mantiene como include) --}}
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

    <footer class="text-center small mt-5 mb-3 textoblanco">
        © {{ date('Y') }} Funkystep. Todos los derechos reservados.
    </footer>

    {{-- Filtro SVG --}}
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