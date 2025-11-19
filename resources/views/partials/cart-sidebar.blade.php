{{-- ============================================
CARRITO LATERAL (SIDEBAR)
Requiere: $cartItems, $cartTotal
=============================================== --}}
<div id="cartSidebar" class="cart-sidebar shadow-lg text-white">
    {{-- Encabezado --}}
    <div class="cart-header d-flex justify-content-between align-items-center p-3 border-bottom border-secondary">
        <h5 class="fw-bold m-0">Tus productos</h5>
        <button id="closeCartBtn" class="nav-link fw-semibold btn-funky">✕</button>
    </div>

    {{-- Contenido --}}
    <div class="cart-body p-3">
        @if($cartItems->isNotEmpty())
            @foreach($cartItems as $item)
                <div class="cart-item d-flex align-items-center mb-3 border-bottom border-secondary pb-2">
                    {{-- Imagen --}}
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                        class="cart-img me-3">

                    {{-- Información del producto --}}
                    <div class="grow">
                        <h6 class="m-0 text-white">{{ $item->product->name }}</h6>
                        <small class="text-white d-block">{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</small>
                    </div>

                    {{-- Botón eliminar --}}
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="ms-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach

            {{-- Total y botones --}}
            <div class="border-top border-secondary pt-3 text-center">
                <h6>Total:
                    <span class="text-success fw-bold">${{ number_format($cartTotal, 2) }}</span>
                </h6>

                <a href="{{ route('checkout') }}" class="btn btn-success w-100 mt-2 fw-semibold">
                    Ir a pagar
                </a>

                <form action="{{ route('cart.clear') }}" method="POST"
                    onsubmit="return confirm('¿Vaciar el carrito completo?')" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-warning w-100 fw-semibold">
                        Vaciar carrito
                    </button>
                </form>
            </div>
        @else
            {{-- Carrito vacío --}}
            <div class="text-center mt-5">
                <img src="{{ asset('images/logo/funky.png') }}" alt="Carrito vacío" class="opacity-75 mb-3" width="100">
                <p class="text-white">Tu carrito está vacío.</p>
                <a href="{{ route('dashboard') }}" class="btn mt-2 btn-outline-light">
                    Explorar productos
                </a>
            </div>
        @endif
    </div>
</div>