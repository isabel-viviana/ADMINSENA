@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Detalle de convocatoria</p>
            <h1>{{ $convocatoria->course->name_curso }}</h1>
            <p>Revisa la información del programa antes de inscribirte.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <article class="pillar h-100">
                <p class="eyebrow">Información del programa</p>
                <h2>{{ $convocatoria->course->name_curso }}</h2>
                <p>{{ $convocatoria->course->description ?: 'Sin descripción disponible.' }}</p>
                <p><strong>Nivel:</strong> {{ $convocatoria->course->level }}</p>
                <p><strong>Duración:</strong> {{ $convocatoria->course->duration }} meses</p>

                <p class="eyebrow mt-4">Información de la convocatoria</p>
                <p><strong>Centro:</strong> {{ $convocatoria->trainingCenter->name }}</p>
                <p><strong>Jornada:</strong> {{ $convocatoria->schedule }}</p>
                <p><strong>Modalidad:</strong> {{ $convocatoria->modality }}</p>
                <p><strong>Fecha de inicio:</strong> {{ $convocatoria->start_date->format('d/m/Y') }}</p>
                <p><strong>Fecha de finalización:</strong> {{ $convocatoria->end_date->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> {{ $convocatoria->status }}</p>
            </article>
        </div>
        <div class="col-lg-5">
            <article class="pillar h-100">
                <p class="eyebrow">Ocupación</p>
                <h2>{{ $stats['disponibles'] }} cupos disponibles</h2>
                <p>{{ $stats['inscritos'] }} de {{ $stats['total'] }} cupos ocupados.</p>
                <div class="progress mb-4" role="progressbar" aria-label="Porcentaje de ocupación" aria-valuenow="{{ $stats['porcentaje'] }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: {{ $stats['porcentaje'] }}%">{{ $stats['porcentaje'] }}%</div>
                </div>

                @if($inscritos)
                    <span class="btn btn-success disabled">Ya inscrito</span>
                @elseif($convocatoria->status === 'Abierta' && $stats['disponibles'] > 0)
                    <form action="{{ route('inscripcion.store', $convocatoria) }}" method="POST">
                        @csrf
                        <button type="submit" class="sena-button">Inscribirme <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                    </form>
                @endif
            </article>
        </div>
    </div>
</div>
@endsection