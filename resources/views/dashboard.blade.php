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
                        👥 Gestionar Usuarios
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal para cambiar foto de perfil --}}
    @if(Auth::check())
        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="photoModalLabel">Editar perfil</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            {{-- Foto de perfil --}}
                            <div class="text-center mb-4">
                                <img src="{{ Auth::user()->profile_photo
            ? asset('storage/' . Auth::user()->profile_photo)
            : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}" alt="Foto actual"
                                    class="rounded-circle mb-3" width="120" height="120">
                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label fw-bold">Cambiar foto</label>
                                    <input type="file" name="profile_photo" accept="image/*" class="form-control">
                                </div>
                            </div>

                            <hr>

                            {{-- Datos de envío --}}
                            <h6 class="fw-bold text-center mb-3">Información de envío</h6>

                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', Auth::user()->address) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', Auth::user()->city) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="postal_code" class="form-control"
                                    value="{{ old('postal_code', Auth::user()->postal_code) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Número de Teléfono</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ old('phone_number', Auth::user()->phone_number) }}">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>