@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Registrar docente" action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control">
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
    </div>

    <div class="mb-3">
        <label for="courses" class="form-label">Cursos (Selecciona uno o varios)</label>
        <select name="courses[]" id="courses" class="form-select" multiple>
            <option value="">Seleccione cursos</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name_curso }} - {{ $course->day }}</option>
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