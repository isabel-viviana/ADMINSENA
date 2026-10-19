@extends('layouts.app')

@section('content')
@php
    $personaId = Auth::user()->person?->id;
    $myEnrollments = $personaId
        ? \App\Models\Academic\Enrollment::where('persona_id', $personaId)->where('status', 'Inscrito')->count()
        : 0;
    $openCalls = \App\Models\Academic\Intake::where('status', 'Abierta')->where('quota', '>', 0)->count();
    $nextCall = \App\Models\Academic\Intake::where('status', 'Abierta')->where('start_date', '>=', now()->toDateString())->orderBy('start_date')->first();
@endphp
<main class="container py-5">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Portal del aprendiz</p>
            <h1>Bienvenido, {{ Auth::user()->name }}</h1>
            <p>Consulta tu espacio personal de formación.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4"><article class="pillar h-100"><p class="eyebrow">Mi actividad</p><h2>{{ $myEnrollments }}</h2><p>Mis inscripciones</p></article></div>
        <div class="col-md-4"><article class="pillar h-100"><p class="eyebrow">Oportunidades</p><h2>{{ $openCalls }}</h2><p>Convocatorias abiertas</p></article></div>
        <div class="col-md-4"><article class="pillar h-100"><p class="eyebrow">Próxima fecha</p><h2>{{ $nextCall ? $nextCall->start_date->format('d/m/Y') : 'No disponible' }}</h2><p>Próxima convocatoria</p></article></div>
    </div>

    <a class="sena-button sena-button--light mb-4" href="{{ route('portal.convocatorias') }}">Explorar programas <i class="fas fa-arrow-right" aria-hidden="true"></i></a>

    <section class="mb-5" aria-labelledby="open-calls-title">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Oferta disponible</p>
                <h2 id="open-calls-title">Convocatorias abiertas</h2>
                <p>Elige una convocatoria e inscríbete para iniciar tu proceso de formación.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($convocatorias as $convocatoria)
                <div class="col-lg-6">
                    <article class="pillar h-100">
                        <p><span class="badge bg-success">{{ $convocatoria->status }}</span></p>
                        <h3>{{ $convocatoria->course->name_curso }}</h3>
                        <p>{{ $convocatoria->course->description }}</p>
                        <p><strong>Centro:</strong> {{ $convocatoria->trainingCenter->name }}</p>
                        <p><strong>Jornada:</strong> {{ $convocatoria->schedule }}</p>
                        <p><strong>Modalidad:</strong> {{ $convocatoria->modality }}</p>
                        <p><strong>Inicio:</strong> {{ $convocatoria->start_date->format('d/m/Y') }}</p>

                        @if(in_array($convocatoria->id, $inscritos))
                            <span class="btn btn-success disabled">Ya estás inscrito</span>
                        @else
                            <form action="{{ route('inscripcion.store', $convocatoria) }}" method="POST">
                                @csrf
                                <button type="submit" class="sena-button">Inscribirme <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                            </form>
                        @endif
                    </article>
                </div>
            @empty
                <div class="col-12"><p>No hay convocatorias abiertas en este momento.</p></div>
            @endforelse
        </div>
    </section>

    <div class="pillar-grid">
        <article class="pillar">
            <i class="fas fa-user-graduate" aria-hidden="true"></i>
            <h2>Mi información</h2>
            <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Correo:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Rol:</strong> Aprendiz</p>
        </article>
        <article class="pillar">
            <i class="fas fa-book-open" aria-hidden="true"></i>
            <h2>Programas disponibles</h2>
            <p>Consulta las convocatorias abiertas de los programas de formación.</p>
            <a class="sena-button" href="{{ route('portal.convocatorias') }}">Ver programas <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-clipboard-list" aria-hidden="true"></i>
            <h2>Mis inscripciones</h2>
            <p>Consulta el estado de tus inscripciones.</p>
            <a class="sena-button" href="{{ route('portal.mis-inscripciones') }}">Ver inscripciones <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
    </div>
</main>
@endsection
