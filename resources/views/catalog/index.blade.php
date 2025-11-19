@extends('layouts.app')

@section('title', 'Catálogo | Funkystep')
@section('content')
    <div>
        <h2 class="fw-bold text-center mb-4 text-white ">Catálogo de Productos</h2>
        <p class="subtitle">Si lo piensas, lo encuentras en FunkyStep</p>

        <div class="catalogo-container">
            <aside class="sidebar-filtros">
                <h5>Filtros</h5>
                <form method="GET" action="{{ route('catalog.index') }}">
                    {{-- Búsqueda por nombre --}}
                    <label for="search">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Nombre o descripción...">

                    {{-- Marca --}}
                    <label for="brand">Marca</label>
                    <select name="brand" id="brand" class="form-select">
                        <option value="">Todas</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>

                    {{-- Categoría --}}
                    <label for="category">Categoría</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}</option>
                        @endforeach
                    </select>

                    {{-- Precio mínimo --}}
                    <label for="min_price">Precio mínimo</label>
                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                        class="form-control" placeholder="Desde $">

                    {{-- Precio máximo --}}
                    <label for="max_price">Precio máximo</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                        class="form-control" placeholder="Hasta $">

                    {{-- Botones --}}
                    <div class="mt-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-semibold">
                            <i class="bi bi-funnel"></i> Aplicar filtros
                        </button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-light">
                            Limpiar
                        </a>
                    </div>
                </form>
            </aside>

            {{-- 💎 PRODUCTOS --}}
            <section class="productos-grid" data-aos="fade-up" >
                @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                @else
                    <div class="text-center text-muted mt-5">
                        <p>No hay productos disponibles con esos criterios.</p>
                    </div>
                @endif

                
            </section>
            {{-- Paginador --}}
                
        </div>
        @if(method_exists($products, 'hasPages') && $products->hasPages())
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $products->appends(request()->query())->onEachSide(1)->links('pagination::funkystep') }}
                    </div>
                @endif
    </div>
@endsection