<main class="hero">
        <div class="video-container">
            <video autoplay loop muted playsinline id="bg-video"
                src="{{ Vite::asset('public/videos/banner/funkystepbaner.mp4') }}">
            </video>
            <div class="separator"></div>
            <div class="fw-bold text-uppercase overlay">
                <h1>FUNKYSTEP</h1>
                <p>PASO A PASO EL TRIUNFO LLEGARÁ</p>
            </div>

        </div>
        <div class="container-fluid px-5 hero-grid">
            {{-- Texto principal --}}
            <section aria-labelledby="hero-title">
                <p class="tag">NIKE AIR MAX 90</p>
                <h1 id="hero-title" class="title">AIR MAX</h1>
                <h2 class="subtitle">NIKE AIR MAX 90</h2>
                <p class="price">$160.000</p>
                <p class="desc">
                    <span class="cursor line1">Nothing as fly, nothing as comfortable, nothing as proven —</span>
                    <span class="cursor line2">the NIKE AIR MAX 90 stays true to level.</span>
                </p>

                @auth
                    <form action="{{ route('cart.add', 22) }}" method="POST">
                        @csrf
                        <button type="submit" class="cta d-inline-flex align-items-center gap-2">
                            AGREGAR AL CARRITO
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="cta d-inline-flex align-items-center gap-2 text-decoration-none">
                        INICIAR SESIÓN PARA COMPRAR
                    </a>
                @endauth
            </section>

            {{-- Imagen principal --}}
            <section class="visual" aria-label="Vista del producto">
                <img src="{{ Vite::asset('public/images/ofer/image.png') }}"
                    alt="Zapatilla Nike Air Max 90 en gris y negro" />

                {{-- Burbujas decorativas (mantengo clases b1..b6) --}}
                <div class="bubble-wrap b1"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b2"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b3"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b4"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b5"><span class="bubble" aria-hidden="true"></span></div>
                <div class="bubble-wrap b6"><span class="bubble" aria-hidden="true"></span></div>
            </section>
        </div>
        <div class="container-fluid px-5 hero-grid">
            {{-- Imagen decorativa secundaria --}}
            <section class="visual2-wrap" aria-label="Vista del producto">
                <img id="visual2" src="{{ Vite::asset('public/images/decoration/image1.png') }}"
                    alt="Zapatilla Nike Air Max 90 en gris y negro" class="visual2" />
            </section>
            <section class="visual2-wrap" aria-label="Vista del producto">
                <img src="{{ Vite::asset('public\images\decoration\HallowenBaner.png') }}"
                    alt="Zapatilla Nike Air Max 90 en gris y negro" class="visual2" />
            </section>
        </div>
    </main>
     {{-- Filtro SVG --}}
    <svg style="display: none">
        <filter id="glass-distortion" x="0%" y="0%" width="100%" height="100%" filterUnits="objectBoundingBox">
            <feTurbulence type="fractalNoise" baseFrequency="0.01 0.01" numOctaves="1" seed="5" result="turbulence" />
            <feComponentTransfer in="turbulence" result="mapped">
                <feFuncR type="gamma" amplitude="1" exponent="10" offset="0.5" />
                <feFuncG type="gamma" amplitude="0" exponent="1" offset="0" />
                <feFuncB type="gamma" amplitude="0" exponent="1" offset="0.5" />
            </feComponentTransfer>
            <feGaussianBlur in="turbulence" stdDeviation="3" result="softMap" />
            <feSpecularLighting in="softMap" surfaceScale="5" specularConstant="1" specularExponent="100"
                lighting-color="white" result="specLight">
                <fePointLight x="-200" y="-200" z="300" />
            </feSpecularLighting>
            <feComposite in="specLight" operator="arithmetic" k1="0" k2="1" k3="1" k4="0" result="litImage" />
            <feDisplacementMap in="SourceGraphic" in2="softMap" scale="150" xChannelSelector="R" yChannelSelector="G" />
        </filter>
    </svg>
