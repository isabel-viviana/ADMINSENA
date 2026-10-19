@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Editar aprendiz" action="{{ route('apprentice.update', $apprentice->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name_apren" class="form-label">Nombre</label>
        <input
            type="text"
            name="name_apren"
            id="name_apren"
            class="form-control"
            value="{{ $apprentice->name_apren }}">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{ $apprentice->email }}">
    </div>

    <div class="mb-3">
        <label for="cell" class="form-label">Celular</label>
        <input
            type="text"
            name="cell"
            id="cell"
            class="form-control"
            value="{{ $apprentice->cell }}">
    </div>

    <div class="mb-3">
        <label for="course_id" class="form-label">Curso</label>
        <select name="course_id" id="course_id" class="form-select">
            <option value="">Seleccione un curso</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $apprentice->course_id == $course->id ? 'selected' : '' }}>{{ $course->name_curso }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="computer_id" class="form-label">Computador</label>
        <select name="computer_id" id="computer_id" class="form-select">
            <option value="">Seleccione un computador</option>
            @foreach($computers as $computer)
                <option value="{{ $computer->id }}" {{ $apprentice->computer_id == $computer->id ? 'selected' : '' }}>{{ $computer->numero }} - {{ $computer->marca }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection
