@extends('layouts.app')

@section('content')
    @vite(['resources/css/app.css'])
    <div >
        <h2 class="fw-bold text-center mb-4 text-white ">Catálogo de Productos</h2>
        <p class="subtitle">Si lo piensas, lo encuentras en FunkyStep</p>
        <x-catalogo :products="$products" />
    </div>
@endsection