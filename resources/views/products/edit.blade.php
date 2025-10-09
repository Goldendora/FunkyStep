@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-center mb-4">Editar Producto</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow border-0">
        @csrf
        @method('PUT')
        @include('products.partials.form', ['buttonText' => 'Actualizar Producto'])
    </form>
</div>
@endsection
