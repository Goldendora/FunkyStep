<div class="mb-3">
    <label class="form-label fw-bold">Nombre del producto</label>
    <input type="text" name="name" class="form-control" 
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Descripción</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Precio ($)</label>
        <input type="number" step="0.01" name="price" class="form-control" 
               value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Descuento (%)</label>
        <input type="number" step="0.01" name="discount" class="form-control" 
               value="{{ old('discount', $product->discount ?? 0) }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Stock</label>
        <input type="number" name="stock" class="form-control" 
               value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Categoría</label>
        <input type="text" name="category" class="form-control" 
               value="{{ old('category', $product->category ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Marca</label>
        <input type="text" name="brand" class="form-control" 
               value="{{ old('brand', $product->brand ?? '') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">SKU</label>
        <input type="text" name="sku" class="form-control" 
               value="{{ old('sku', $product->sku ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Imagen del producto</label>
        <input type="file" name="image" class="form-control">
        @if(!empty($product->image))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     width="120" height="120" class="rounded shadow-sm" 
                     style="object-fit: cover;">
            </div>
        @endif
    </div>
</div>

<div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
           {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label fw-bold" for="is_active">Producto activo</label>
</div>

<div class="text-center">
    <button type="submit" class="btn btn-primary px-4">{{ $buttonText }}</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Cancelar</a>
</div>
