@extends('layouts.app')

@section('content')
    @vite(['resources/css/table.css'])

    {{-- Tabla fullscreen real --}}
    <table class="tabla-fullscreen .fixed-table" role="grid">
        <thead>
            <tr>
                <th>Foto</th>
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
                @php $baneo = $user->baneoActivo; @endphp
                <tr>
                    {{-- FOTO --}}
                    <td class="foto-perfil">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de {{ $user->name }}"
                                class="rounded-circle profile-img">
                        @else
                            <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center profile-placeholder">
                                <i class="bi bi-person text-white fs-5"></i>
                            </div>
                        @endif
                    </td>

                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-primary">{{ strtoupper($user->role ?? 'user') }}</span>
                    </td>
                    <td>
                        @if($baneo)
                            <span class="badge bg-danger">BANEADO</span>
                        @else
                            <span class="badge bg-success">ACTIVO</span>
                        @endif
                    </td>
                    <td class="acciones">
                        {{-- Cambiar rol --}}
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST"
                            class="d-flex gap-2 align-items-center flex-wrap justify-content-center">
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
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#banModal{{ $user->id }}">
                                Banear
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 🔹 MODALES FUERA DE LA TABLA (corrección estructural) --}}
    @foreach($users as $user)
        <div class="modal fade" id="banModal{{ $user->id }}" tabindex="-1" aria-hidden="true"
             data-bs-backdrop="true" data-bs-scroll="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white border-light">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger">Banear usuario: {{ $user->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('users.ban', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Motivo del baneo:</label>
                                <input type="text" name="motivo" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Duración (en días, vacío = permanente):</label>
                                <input type="number" name="duracion_dias" class="form-control bg-dark text-white border-secondary" min="1">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Confirmar baneo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

