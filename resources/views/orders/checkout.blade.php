<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar compra - Funkystep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .checkout-container {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 3rem;
        }
        .btn-stripe {
            background-color: #6772e5;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-stripe:hover {
            background-color: #5469d4;
        }
    </style>
</head>

<body>

    {{-- Navbar igual que en el carrito --}}
    <nav class="navbar navbar-dark shadow-sm px-4" style="background-color:#212529;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Funkystep</a>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light btn-sm">Volver al carrito</a>
        </div>
    </nav>

    <div class="container">
        <div class="checkout-container">
            <h2 class="fw-bold text-center mb-4">Confirmar compra</h2>

            <table class="table align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <h4>Total a pagar: <span class="text-success fw-bold">${{ number_format($total, 2) }}</span></h4>
            </div>

            <form action="{{ route('checkout.pay') }}" method="POST" class="mt-4">
                @csrf
                <button class="btn btn-stripe w-100 py-2">
                    Pagar con tarjeta 
                </button>
            </form>
            <form action="{{ route('cart.index') }}" class="mt-4">
                @csrf
                <button class="btn btn-stripe w-100 py-2">
                    Regresar al catálogo
                </button>
            </form>
        </div>
    </div>

    <footer class="text-center small mt-5 mb-3 text-muted">
        © {{ date('Y') }} Funkystep. Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
