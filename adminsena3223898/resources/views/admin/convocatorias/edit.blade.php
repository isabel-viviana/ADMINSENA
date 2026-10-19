@extends('layouts.app')

@section('content')
<form class="module-form" data-form-title="Editar convocatoria" action="{{ route('convocatoria.update', $convocatoria) }}" method="POST">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="course_id" class="form-label">Programa de Formación</label>
        <select name="course_id" id="course_id" class="form-select" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id', $convocatoria->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name_curso }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="training_center_id" class="form-label">Centro de formación</label>
        <select name="training_center_id" id="training_center_id" class="form-select" required>
            @foreach($trainingCenters as $trainingCenter)
                <option value="{{ $trainingCenter->id }}" {{ old('training_center_id', $convocatoria->training_center_id) == $trainingCenter->id ? 'selected' : '' }}>{{ $trainingCenter->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="schedule" class="form-label">Jornada</label>
        <select name="schedule" id="schedule" class="form-select" required>
            @foreach(['Mañana', 'Tarde', 'Noche'] as $schedule)
                <option value="{{ $schedule }}" {{ old('schedule', $convocatoria->schedule) === $schedule ? 'selected' : '' }}>{{ $schedule }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="modality" class="form-label">Modalidad</label>
        <select name="modality" id="modality" class="form-select" required>
            @foreach(['Presencial', 'Virtual', 'Mixta'] as $modality)
                <option value="{{ $modality }}" {{ old('modality', $convocatoria->modality) === $modality ? 'selected' : '' }}>{{ $modality }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="quota" class="form-label">Cupos</label>
        <input type="number" name="quota" id="quota" class="form-control" min="1" value="{{ old('quota', $convocatoria->quota) }}" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $convocatoria->start_date->format('Y-m-d')) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label">Fecha de finalización</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $convocatoria->end_date->format('Y-m-d')) }}" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Estado</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['Abierta', 'Cerrada', 'Finalizada'] as $status)
                <option value="{{ $status }}" {{ old('status', $convocatoria->status) === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar convocatoria</button>
</form>
@endsection
