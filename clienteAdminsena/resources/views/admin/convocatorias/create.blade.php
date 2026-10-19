@extends('layouts.app')

@section('content')
<form class="module-form" data-form-title="Crear convocatoria" action="{{ route('convocatoria.store') }}" method="POST">
    @csrf

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
            <option value="">Seleccione un programa</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name_curso }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="training_center_id" class="form-label">Centro de formación</label>
        <select name="training_center_id" id="training_center_id" class="form-select" required>
            <option value="">Seleccione un centro</option>
            @foreach($trainingCenters as $trainingCenter)
                <option value="{{ $trainingCenter->id }}" {{ old('training_center_id') == $trainingCenter->id ? 'selected' : '' }}>{{ $trainingCenter->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="schedule" class="form-label">Jornada</label>
        <select name="schedule" id="schedule" class="form-select" required>
            <option value="">Seleccione una jornada</option>
            @foreach(['Mañana', 'Tarde', 'Noche'] as $schedule)
                <option value="{{ $schedule }}" {{ old('schedule') === $schedule ? 'selected' : '' }}>{{ $schedule }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="modality" class="form-label">Modalidad</label>
        <select name="modality" id="modality" class="form-select" required>
            <option value="">Seleccione una modalidad</option>
            @foreach(['Presencial', 'Virtual', 'Mixta'] as $modality)
                <option value="{{ $modality }}" {{ old('modality') === $modality ? 'selected' : '' }}>{{ $modality }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="quota" class="form-label">Cupos</label>
        <input type="number" name="quota" id="quota" class="form-control" min="1" value="{{ old('quota') }}" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label">Fecha de finalización</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Estado</label>
        <select name="status" id="status" class="form-select" required>
            @foreach(['Abierta', 'Cerrada', 'Finalizada'] as $status)
                <option value="{{ $status }}" {{ old('status', 'Abierta') === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar convocatoria</button>
</form>
@endsection
