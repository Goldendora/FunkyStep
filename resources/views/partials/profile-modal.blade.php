<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="photoModalLabel">Editar perfil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Foto de perfil --}}
                    <div class="text-center mb-4">
                        <img src="{{ Auth::user()->profile_photo
                            ? asset('storage/' . Auth::user()->profile_photo)
                            : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}"
                            alt="Foto actual" class="rounded-circle mb-3" width="120" height="120">
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
