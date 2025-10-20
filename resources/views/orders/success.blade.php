<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago exitoso - Funkystep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-container {
            background: #fff;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 5rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark shadow-sm px-4" style="background-color:#212529;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Funkystep</a>
        </div>
    </nav>

    <div class="container">
        <div class="success-container">
            <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Éxito" width="100">
            <h2 class="text-success fw-bold mt-3">¡Pago completado con éxito!</h2>
            <p class="mt-2">Tu pedido ha sido procesado correctamente. 🎉</p>

            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Volver al catálogo</a>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary mt-3">Ver carrito</a>
        </div>
    </div>

    <footer class="text-center small mt-5 mb-3 text-muted">
        © {{ date('Y') }} Funkystep. Todos los derechos reservados.
    </footer>
</body>
</html>
