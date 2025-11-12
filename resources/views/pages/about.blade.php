@extends('layouts.app')

@section('title', 'About | Funkystep')

@section('content')
    <div class="container py-5 text-white" data-aos="fade-up" >
        <h2 class="fw-bold text-center mb-3 display-4">SOBRE FUNKYSTEP</h2>
        <p class="subtitle text-center">Una marca caleña que nació de la pasión y la creatividad universitaria</p>

        <div class="row align-items-center mt-5">
            <div class="col-md-6">
                <h4 class="text-warning mb-3">Nuestra historia</h4>
                <p>
                    <strong>Funkystep</strong> es una marca caleña que surgió hace aproximadamente un año en las aulas de la
                    <strong>Universidad Santiago de Cali</strong>, como un proyecto académico que pronto se convirtió en una
                    visión empresarial.
                    Fundada por un grupo de jóvenes emprendedores apasionados por el diseño, la moda y la tecnología,
                    Funkystep nació con el propósito de ofrecer zapatillas modernas, cómodas y con identidad local.
                </p>
                <p>
                    Lo que comenzó como una idea en clase se transformó en una tienda en línea
                    con un sistema de e-commerce completo desarrollado en <strong>Laravel</strong>,
                    conectando a cientos de clientes con las últimas tendencias del calzado urbano.
                </p>
            </div>

            <div class="col-md-6 text-center">
                <img src="{{ asset('images/logo/funky.png') }}" alt="Equipo Funkystep" class="img-fluid"
                    style="max-width: 90%;">
            </div>
        </div>

        <hr class="my-5 border-light opacity-25">

        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <i class="bi bi-lightning-charge-fill text-warning fs-1 icon-hover"></i>
                <h5 class="fw-bold mt-3">Innovación</h5>
                <p>Desarrollamos tecnología y diseño para ofrecer una experiencia de compra moderna, rápida y segura.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-people-fill text-warning fs-1 icon-hover"></i>
                <h5 class="fw-bold mt-3">Comunidad</h5>
                <p>Creemos en el talento local y en el poder de la comunidad caleña para inspirar nuevas tendencias.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="bi bi-globe2 text-warning fs-1 icon-hover"></i>
                <h5 class="fw-bold mt-3">Visión Global</h5>
                <p>Nacimos en Cali, pero soñamos con llevar el estilo Funkystep a toda Latinoamérica.</p>
            </div>
        </div>

        <div class="mt-5 p-4 rounded-4" style="background-color: rgba(255,255,255,0.05);">
            <h4 class="fw-bold text-center mb-3 text-warning">Nuestra misión</h4>
            <p class="text-center">
                Brindar calzado de calidad con diseños auténticos, destacando el arte y la identidad caleña en cada paso.
                Buscamos conectar moda, sostenibilidad y tecnología para mejorar la experiencia de nuestros clientes.
            </p>

            <h4 class="fw-bold text-center mt-5 mb-3 text-warning">Nuestra visión</h4>
            <p class="text-center">
                Convertirnos en una marca líder en innovación y estilo urbano en Colombia,
                reconocida por su compromiso con el talento joven, la tecnología local y la calidad en cada producto.
            </p>
        </div>
    </div>
@endsection