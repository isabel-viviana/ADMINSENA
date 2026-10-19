@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Editar docente" action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            value="{{ $teacher->name }}">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{ $teacher->email }}">
    </div>

    <div class="mb-3">
        <label for="area_id" class="form-label">Área</label>
        <select name="area_id" id="area_id" class="form-select">
            <option value="">Seleccione un área</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ $teacher->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="training_centers_id" class="form-label">Centro de Formación</label>
        <select name="training_centers_id" id="training_centers_id" class="form-select">
            <option value="">Seleccione un centro de formación</option>
            @foreach($trainingCenters as $trainingCenter)
                <option value="{{ $trainingCenter->id }}" {{ $teacher->training_centers_id == $trainingCenter->id ? 'selected' : '' }}>{{ $trainingCenter->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="courses" class="form-label">Cursos (Selecciona uno o varios)</label>
        <select name="courses[]" id="courses" class="form-select" multiple>
            <option value="">Seleccione cursos</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ in_array($course->id, $teacher->courses->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $course->name_curso }} - {{ $course->day }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection
