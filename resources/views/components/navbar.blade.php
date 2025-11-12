<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 shadow-sm fixed-top">
    <div class="container-fluid">
        {{-- LOGO --}}
        <a class="navbar-brand fw-bold text-uppercase" href="{{ route('dashboard') }}">Funkystep</a>

        {{-- Menú de navegación --}}
        <div class="collapse navbar-collapse" id="navbarFunky">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-5">
                <li class="nav-item">
                    <a class="nav-link fw-semibold btn-funky" href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold btn-funky" href="{{ route('catalog.index') }}" >Collection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold btn-funky" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold btn-funky" href="{{ route('contact') }}">Contact</a>
                </li>

                {{-- Si el usuario es admin --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link fw-semibold btn-funky">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link fw-semibold btn-funky">Productos</a>
                    </li>
                @endif
            </ul>

            {{-- Menú derecho: carrito y usuario --}}
            <div class="d-flex align-items-center gap-3">
                @if(Auth::check())
                    {{-- Botón del carrito --}}
                    <div class="cart-btn me-2">
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

                    {{-- Menú desplegable de usuario --}}
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
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="btn-funky btn btn-sm w-100" data-bs-toggle="modal"
                                    data-bs-target="#photoModal">Editar perfil</button>
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
    