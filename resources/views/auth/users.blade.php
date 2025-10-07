<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Funkystep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Funkystep</a>
        <div class="ms-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-4">👥 Gestión de Usuarios</h2>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabla de usuarios --}}
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol actual</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @php
                            $baneo = $user->baneoActivo ?? null;
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary text-uppercase">{{ $user->role }}</span>
                            </td>
                            <td>
                                @if($baneo)
                                    <span class="badge bg-danger">BANEADO</span>
                                @else
                                    <span class="badge bg-success">ACTIVO</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center align-items-center gap-2">

                                {{-- Cambio de rol --}}
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-select form-select-sm w-auto">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                </form>

                                {{-- Botón de baneo/desbaneo --}}
                                @if($baneo)
                                    <form action="{{ route('users.unban', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Desbanear</button>
                                    </form>
                                @else
                                    <!-- Modal de baneo -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#banModal{{ $user->id }}">
                                        Banear
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="banModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Banear usuario: {{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('users.ban', $user->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="motivo" class="form-label">Motivo del baneo:</label>
                                                            <input type="text" name="motivo" id="motivo" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="duracion" class="form-label">Duración (días, dejar vacío para permanente):</label>
                                                            <input type="number" name="duracion_dias" id="duracion" class="form-control" min="1">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Confirmar baneo</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Botón para volver --}}
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">⬅ Volver al Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
