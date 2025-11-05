@if(isset($products) && count($products) > 0)
    <div class="catalogo">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
@else
    <div class="text-center text-muted mt-5">
        <p>No hay productos disponibles en este momento.</p>
    </div>
@endif

{{-- Paginador --}}
@if(method_exists($products, 'hasPages') && $products->hasPages())
    <div class="mt-5 d-flex justify-content-center">
        {{ $products->onEachSide(1)->links('pagination::funkystep') }}
    </div>
@endif