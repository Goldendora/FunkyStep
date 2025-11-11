<div class="product">
    <span class="product__price">
        ${{ number_format($product->price - ($product->price * ($product->discount / 100)), 0, ',', '.') }}
    </span>

    <img class="product__image"
        src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400' }}"
        alt="{{ $product->name }}">

    <span class="product__category">{{ $product->brand }}</span>
    <h1 class="product__title">{{ $product->name }}</h1>
    <hr>

    <p class="desc">{{ Str::limit($product->description, 120) }}</p>

    @if($product->stock > 0)
        @auth
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="product__btn">Agregar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="product__btn text-decoration-none">Login</a>
        @endauth
    @else
        <button class="product__btn" disabled>Agotado</button>
    @endif
</div>