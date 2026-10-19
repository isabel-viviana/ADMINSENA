@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Editar programa de formación" action="{{ route('course.update', $course->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name_curso" class="form-label">Nombre del programa</label>
        <input
            type="text"
            name="name_curso"
            id="name_curso"
            class="form-control"
            value="{{ old('name_curso', $course->name_curso) }}" required>
    </div>

    <div class="mb-3">
        <label for="day" class="form-label">Día</label>
        <input
            type="text"
            name="day"
            id="day"
            class="form-control"
            value="{{ old('day', $course->day) }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $course->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="level" class="form-label">Nivel</label>
        <select name="level" id="level" class="form-select" required>
            <option value="Tecnico" {{ old('level', $course->level) === 'Tecnico' ? 'selected' : '' }}>Técnico</option>
            <option value="Tecnologo" {{ old('level', $course->level) === 'Tecnologo' ? 'selected' : '' }}>Tecnólogo</option>
            <option value="Complementario" {{ old('level', $course->level) === 'Complementario' ? 'selected' : '' }}>Complementario</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="duration" class="form-label">Duración (meses)</label>
        <input type="number" name="duration" id="duration" class="form-control" min="1" max="65535" value="{{ old('duration', $course->duration) }}" required>
    </div>

    <div class="mb-3">
        <label for="area_id" class="form-label">Área</label>
        <select name="area_id" id="area_id" class="form-select">
            <option value="">Seleccione un área</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ $course->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="training_centers_id" class="form-label">Centro de Formación</label>
        <select name="training_centers_id" id="training_centers_id" class="form-select">
            <option value="">Seleccione un centro de formación</option>
            @foreach($trainingCenters as $trainingCenter)
                <option value="{{ $trainingCenter->id }}" {{ $course->training_centers_id == $trainingCenter->id ? 'selected' : '' }}>{{ $trainingCenter->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="teachers" class="form-label">Profesores (Selecciona uno o varios)</label>
        <select name="teachers[]" id="teachers" class="form-select" multiple>
            <option value="">Seleccione profesores</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ in_array($teacher->id, $course->teachers->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $teacher->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection
