@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Registrar programa de formación" action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label for="name_curso" class="form-label">Nombre del programa</label>
        <input type="text" name="name_curso" id="name_curso" class="form-control" value="{{ old('name_curso') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="level" class="form-label">Nivel</label>
        <select name="level" id="level" class="form-select" required>
            <option value="">Seleccione un nivel</option>
            <option value="Tecnico" {{ old('level') === 'Tecnico' ? 'selected' : '' }}>Técnico</option>
            <option value="Tecnologo" {{ old('level') === 'Tecnologo' ? 'selected' : '' }}>Tecnólogo</option>
            <option value="Complementario" {{ old('level') === 'Complementario' ? 'selected' : '' }}>Complementario</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="duracion_horas" class="form-label">Duración (horas)</label>
        <input type="number" name="duracion_horas" id="duracion_horas" class="form-control" min="0" value="{{ old('duracion_horas') }}">
    </div>

    <div class="mb-3">
        <label for="area_id" class="form-label">Área</label>
        <select name="area_id" id="area_id" class="form-select">
            <option value="">Seleccione un área</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="training_centers_id" class="form-label">Centro de Formación</label>
        <select name="training_centers_id" id="training_centers_id" class="form-select">
            <option value="">Seleccione un centro de formación</option>
            @foreach($trainingCenters as $trainingCenter)
                <option value="{{ $trainingCenter->id }}">{{ $trainingCenter->name }}</option>
            @endforeach
        </select>

            <label for="teachers" class="form-label">Docentes</label>
            <select name="teachers[]" id="teachers" class="form-select" multiple>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>

            <br>
        <input type="text" name="marca" id="marca" class="form-control">
        <br>
        <input type="file" name="urlFoto" class="form-control-file" accept="image/*">

    </div>

    <button type="submit" class="btn btn-primary">Enviar Formulario</button>
</form>

@endsection