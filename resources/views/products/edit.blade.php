@extends('layouts.app')

@section('content')
    @vite(['resources/css/form.css'])

    <div class="product-create-fullscreen container-fluid py-5">
        <div class="mx-auto form-box-funky p-5 rounded-4 shadow-lg">
            <h2 class="fw-bold text-white text-center mb-4">Editar zapatilla</h2>

            {{-- Validaciones --}}
            @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 shadow-sm">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('products.partials.form', ['buttonText' => 'Guardar producto'])
            </form>
        </div>

        {{-- Volver --}}
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Volver</a>
        </div>
    </div>
@endsection
