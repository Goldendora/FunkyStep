@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow p-4 border-0">
        <h2 class="mb-4 fw-bold">Gestión de Usuarios</h2>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Tabla de usuarios --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @php
                            $baneo = $user->baneoActivo;
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ strtoupper($user->role ?? 'user') }}
                                </span>
                            </td>
                            <td>
                                @if($baneo)
                                    <span class="badge bg-danger">BANEADO</span>
                                @else
                                    <span class="badge bg-success">ACTIVO</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center align-items-center gap-2 flex-wrap">

                                {{-- Cambiar rol --}}
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-select form-select-sm w-auto">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                </form>

                                {{-- Banear / Desbanear --}}
                                @if($baneo)
                                    <form action="{{ route('users.unban', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Desbanear</button>
                                    </form>
                                @else
                                    <!-- Botón para abrir modal -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#banModal{{ $user->id }}">
                                        Banear
                                    </button>

                                    <!-- Modal de confirmación -->
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
                                                            <label class="form-label">Motivo del baneo:</label>
                                                            <input type="text" name="motivo" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Duración (en días, vacío = permanente):</label>
                                                            <input type="number" name="duracion_dias" class="form-control" min="1">
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
        </div>

        <div class="text-end mt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</div>
@endsection
