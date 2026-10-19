@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Oferta disponible</p>
            <h1>Programas disponibles</h1>
            <p>Consulta las convocatorias abiertas e inscríbete en la que prefieras.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('portal.convocatorias') }}" class="row g-3 mb-5">
        <div class="col-lg-4">
            <label for="programa" class="form-label">Nombre del programa</label>
            <input type="search" name="programa" id="programa" class="form-control" value="{{ $filters['programa'] ?? '' }}" placeholder="Buscar programa">
        </div>
        <div class="col-lg-2">
            <label for="area_id" class="form-label">Área</label>
            <select name="area_id" id="area_id" class="form-select">
                <option value="">Todas</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ ($filters['area_id'] ?? '') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <label for="training_center_id" class="form-label">Centro</label>
            <select name="training_center_id" id="training_center_id" class="form-select">
                <option value="">Todos</option>
                @foreach($trainingCenters as $trainingCenter)
                    <option value="{{ $trainingCenter->id }}" {{ ($filters['training_center_id'] ?? '') == $trainingCenter->id ? 'selected' : '' }}>{{ $trainingCenter->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <label for="modality" class="form-label">Modalidad</label>
            <select name="modality" id="modality" class="form-select">
                <option value="">Todas</option>
                @foreach(['Presencial', 'Virtual', 'Mixta'] as $modality)
                    <option value="{{ $modality }}" {{ ($filters['modality'] ?? '') === $modality ? 'selected' : '' }}>{{ $modality }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <label for="schedule" class="form-label">Jornada</label>
            <select name="schedule" id="schedule" class="form-select">
                <option value="">Todas</option>
                @foreach(['Mañana', 'Tarde', 'Noche'] as $schedule)
                    <option value="{{ $schedule }}" {{ ($filters['schedule'] ?? '') === $schedule ? 'selected' : '' }}>{{ $schedule }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-success">Filtrar</button>
            <a href="{{ route('portal.convocatorias') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <div class="row g-4">
        @forelse($convocatorias as $convocatoria)
            <div class="col-lg-6">
                <article class="pillar h-100">
                    <p><span class="badge bg-success">{{ $convocatoria->status }}</span></p>
                    <h2>{{ $convocatoria->course->name_curso }}</h2>
                    <p>{{ $convocatoria->course->description }}</p>
                    <p><strong>Centro:</strong> {{ $convocatoria->trainingCenter->name }}</p>
                    <p><strong>Jornada:</strong> {{ $convocatoria->schedule }}</p>
                    <p><strong>Modalidad:</strong> {{ $convocatoria->modality }}</p>
                    <p><strong>Cupos disponibles:</strong> {{ $convocatoria->quota }}</p>
                    <p><strong>Fecha de inicio:</strong> {{ $convocatoria->start_date->format('d/m/Y') }}</p>

                    <a class="btn btn-outline-success mb-3" href="{{ route('portal.convocatoria.detail', $convocatoria) }}">Ver detalle</a>

                    @if($convocatoria->quota < 1)
                        <span class="badge bg-danger">Cupos agotados</span>
                    @elseif(in_array($convocatoria->id, $inscritos))
                        <span class="btn btn-success disabled">Ya inscrito</span>
                    @else
                        <form action="{{ route('inscripcion.store', $convocatoria) }}" method="POST">
                            @csrf
                            <button type="submit" class="sena-button">Inscribirme <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                        </form>
                    @endif
                </article>
            </div>
        @empty
            <div class="col-12"><p class="text-center">No hay convocatorias abiertas disponibles.</p></div>
        @endforelse
    </div>
</div>
@endsection
