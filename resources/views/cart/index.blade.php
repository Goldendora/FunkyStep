<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito - Funkystep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #212529;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            cursor: pointer;
        }

        .cart-container {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 3rem;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .btn-checkout {
            background-color: #28a745;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #218838;
        }

        .empty-cart {
            text-align: center;
            padding: 5rem 0;
        }

        .empty-cart img {
            width: 150px;
            opacity: 0.8;
        }

        footer {
            margin-top: 4rem;
            color: #6c757d;
        }
    </style>
</head>

<body>

    {{-- Navbar superior --}}
    <nav class="navbar navbar-dark shadow-sm px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Funkystep</a>

            <div class="ms-auto d-flex align-items-center gap-3">
                @auth
                    {{-- Carrito --}}
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light btn-sm">
                        🛒 Mi carrito
                    </a>

                    {{-- Menú usuario --}}
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo
                                ? asset('storage/' . Auth::user()->profile_photo)
                                : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}"
                                alt="Foto de perfil" class="profile-img me-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                            <li class="dropdown-item text-center">
                                <strong>{{ Auth::user()->name }}</strong>
                                <p class="text-muted mb-0 small">{{ Auth::user()->email }}</p>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button"
                                    class="dropdown-item text-center btn btn-outline-primary btn-sm w-100"
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
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <div class="container">
        <div class="cart-container">
            <h2 class="fw-bold text-center mb-4">Mi carrito</h2>

            {{-- Mensajes de sesión --}}
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            @if($items->isEmpty())
                <div class="empty-cart">
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Carrito vacío">
                    <h5 class="mt-3 text-muted">Tu carrito está vacío.</h5>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Explorar productos</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                class="product-img me-3" alt="{{ $item->product->name }}">
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->product->brand }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                min="1" class="form-control d-inline w-50 text-center">
                                            <button class="btn btn-sm btn-outline-primary mt-2">Actualizar</button>
                                        </form>
                                    </td>
                                    <td class="fw-bold text-success">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                            onsubmit="return confirm('¿Eliminar este producto del carrito?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Total y acciones --}}
                <div class="row mt-4">
                    <div class="col-md-6">
                        <form action="{{ route('cart.clear') }}" method="POST"
                            onsubmit="return confirm('¿Vaciar el carrito completo?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-warning w-100">Vaciar carrito</button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="p-3 bg-light rounded">
                            <h5 class="mb-2">Total a pagar:</h5>
                            <h3 class="fw-bold text-success">${{ number_format($total, 2) }}</h3>
                            <a href="#" class="btn btn-checkout w-100 mt-3">Proceder al pago 💳</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <footer class="text-center small mt-5 mb-3 text-muted">
        © {{ date('Y') }} Funkystep. Todos los derechos reservados.
    </footer>

    @if(Auth::check())
        @include('partials.profile-modal')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
