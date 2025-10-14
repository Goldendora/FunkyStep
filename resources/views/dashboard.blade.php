<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Funkystep123</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @vite(['resources/css/style.css'])
</head>

<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 shadow-sm">
        <a class="navbar-brand fw-bold" href="#">Funkystep</a>

        <div class="ms-auto d-flex align-items-center gap-3">

            @if(Auth::check())
                    {{-- Botón del carrito --}}
                    <div class="cart-btn me-3">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                            Carrito
                            @php
                                $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-count">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>

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
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-1">
                                        Cerrar sesión
                                    </button>
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
                        Panel administrativo
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
                        <div class="card h-100 shadow-sm border-0" style="cursor: pointer;">
                            <img src="{{ $product->image
                    ? asset('storage/' . $product->image)
                    : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}"
                                style="height: 250px; object-fit: cover;" onclick="showProductModal(
                                                                    '{{ $product->name }}',
                                                                    '{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600' }}',
                                                                    '{{ $product->brand }}',
                                                                    '{{ $product->category }}',
                                                                    '{{ $product->description }}',
                                                                    '{{ number_format($product->price - ($product->price * ($product->discount / 100)), 0, ',', '.') }}',
                                                                    '{{ $product->discount }}',
                                                                    '{{ $product->stock }}'
                                                                )">

                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                <p class="text-muted small mb-1">{{ $product->brand }}</p>
                                <p class="fw-bold text-success mb-1">
                                    ${{ number_format($product->price - ($product->price * ($product->discount / 100)), 2) }}
                                </p>

                                @if($product->discount > 0)
                                    <p class="text-danger small mb-2">
                                        <del>${{ number_format($product->price, 2) }}</del>
                                        -{{ $product->discount }}%
                                    </p>
                                @endif

                                @if($product->stock > 0)
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                                Agregar al carrito
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm w-100">
                                            Inicia sesión para comprar
                                        </a>
                                    @endauth
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Paginador -->
                @if ($products->hasPages())
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                    <!-- Encabezado del modal -->
                    <div class="modal-header border-0 bg-gradient text-white py-3 px-4">
                        <h4 class="modal-title fw-bold" id="modalTitle"></h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <!-- Cuerpo -->
                    <div class="modal-body p-0 bg-light">
                        <div class="row g-0 align-items-stretch">

                            <!-- Imagen -->
                            <div class="col-md-6 d-flex align-items-center justify-content-center bg-white p-4">
                                <img id="modalImage" class="img-fluid rounded-3 shadow-sm"
                                    style="max-height: 450px; object-fit: cover;" alt="Producto">
                            </div>

                            <!-- Información -->
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
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        Agotado
                                    </button>
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
    {{-- Modal de perfil --}}
    @if(Auth::check())
        @include('partials.profile-modal')

    @endif
    <footer class="text-center small mt-5 mb-3 text-muted">
        © {{ date('Y') }} Funkystep. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showProductModal(name, image, brand, category, description, price, discount, stock) {
            // Rellenar contenido dinámico
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalImage').src = image;
            document.getElementById('modalBrand').textContent = "Marca: " + brand;
            document.getElementById('modalCategory').textContent = "Categoría: " + category;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalPrice').textContent = "$" + price + " COP";
            document.getElementById('modalDiscount').textContent = discount > 0 ? "Descuento: -" + discount + "%" : "";
            document.getElementById('modalStock').textContent = "Disponibles: " + stock + " unidades";

            // Mostrar el modal con Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('productModal'));
            modal.show();
        }
    </script>
</body>

</html>