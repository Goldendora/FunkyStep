@extends('layouts.app')

@section('title', 'Contacto | Funkystep')

@section('content')
    <div class="container py-5 text-white" data-aos="fade-up">
        <!-- Título -->
        <h2 class="fw-bold text-center mb-3 display-4">
            CONTÁCTANOS
        </h2>
        <p class="subtitle text-center">Estamos aquí para resolver tus dudas y escuchar tus ideas</p>

        <!-- Sección contacto -->
        <div class="row align-items-center mt-5">
            <div class="col-md-6" data-aos="fade-right">
                <h4 class="fw-bold mb-3 text-warning">Ponte en contacto</h4>
                <p class="desc">
                    En <strong>Funkystep</strong> nos encanta conectar con nuestra comunidad.
                    Si tienes preguntas, sugerencias o quieres colaborar con nosotros, no dudes en escribirnos.
                </p>

                <ul class="list-unstyled mt-4">
                    <li class="mb-3">
                        <i class="bi bi-envelope-fill text-warning me-2"></i>
                        <strong>Email:</strong> contacto@funkystep.com
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-telephone-fill text-warning me-2"></i>
                        <strong>Teléfono:</strong> +57 312 456 7890
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                        <strong>Ubicación:</strong> Cali, Valle del Cauca, Colombia
                    </li>
                </ul>

                <div class="d-flex gap-3 mt-4">
                    <a href="https://www.instagram.com/funkystep_?igsh=NjZmZDZxbnhzc2Rt&utm_source=qr"
                        class="btn btn-funky d-flex align-items-center gap-2 px-3" target="_blank" rel="noopener">
                        <i class="bi bi-instagram fs-4"></i> Instagram
                    </a>
                    <a href="https://www.facebook.com/share/1CxsSDe8VL/?mibextid=wwXIfr" class="btn btn-funky d-flex align-items-center gap-2 px-3"
                        target="_blank" rel="noopener">
                        <i class="bi bi-facebook fs-4"></i> Facebook
                    </a>
                </div>
            </div>

            <!-- Imagen o logo -->
            <div class="col-md-6 text-center" data-aos="zoom-in">
                <img src="{{ asset('images/logo/funky.png') }}" alt="Logo Funkystep" class="img-fluid"
                    style="max-width: 80%; filter: brightness(0.95);">
            </div>
        </div>

        <hr class="my-5 border-light opacity-25">

        <!-- Mapa (opcional visual) -->
        <div class="rounded-4 overflow-hidden shadow-lg" data-aos="fade-up">
            <iframe src="https://www.google.com/maps?q=Cali,+Valle+del+Cauca,+Colombia&output=embed" width="100%"
                height="400" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>
@endsection