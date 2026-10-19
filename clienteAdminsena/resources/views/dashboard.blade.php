@extends('layouts.app')

@section('content')

<main class="home-page">
    <section class="home-hero" aria-label="Bienvenida institucional">
        <div class="home-hero__copy">
            <p class="eyebrow">Formación que transforma vidas</p>
            <h1>Conocimiento que <em>construye</em> futuro.</h1>
            <p class="home-hero__lead">Un espacio para conectar la formación profesional integral con los centros, equipos y personas que hacen avanzar a Colombia.</p>
            <a class="sena-button sena-button--light" href="#conocenos">Conoce nuestra misión <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="home-hero__mark" aria-hidden="true">SENA</div>
    </section>

    <section class="home-carousel-section" aria-labelledby="carousel-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">En el SENA</p>
                <h2 id="carousel-title">Historias que inspiran</h2>
            </div>
        </div>
        <div id="homeCarousel" class="carousel slide sena-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-label="Historia uno" aria-current="true"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Historia dos"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Historia tres"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="{{ asset('assets/image01.png') }}" alt="Historia uno" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <div class="carousel-item"><img src="{{ asset('assets/image02.png') }}" alt="Historia dos" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <div class="carousel-item"><img src="{{ asset('assets/image03.png') }}" alt="Historia tres" style="width: 100%; height: 100%; object-fit: cover;"></div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Anterior</span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Siguiente</span></button>
        </div>
    </section>

    <section id="conocenos" class="home-pillars" aria-labelledby="pillars-title">
        <div class="section-heading section-heading--compact"><div><p class="eyebrow">Nuestra razón de ser</p><h2 id="pillars-title">Aprender, hacer, transformar.</h2></div></div>
        <div class="pillar-grid">
            <article class="pillar"><span class="pillar__number">01</span><i class="fas fa-seedling" aria-hidden="true"></i><h3>Talento humano</h3><p>Fortalecemos competencias para que cada aprendiz pueda convertir sus ideas en oportunidades.</p></article>
            <article class="pillar"><span class="pillar__number">02</span><i class="fas fa-laptop-code" aria-hidden="true"></i><h3>Innovación aplicada</h3><p>La tecnología y el conocimiento se encuentran para resolver los retos del territorio.</p></article>
            <article class="pillar"><span class="pillar__number">03</span><i class="fas fa-hands-helping" aria-hidden="true"></i><h3>Comunidad</h3><p>Construimos una red de formación pública, cercana y con impacto real.</p></article>
        </div>
    </section>
</div>

@endsection
