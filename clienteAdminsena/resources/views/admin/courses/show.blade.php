@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Información del programa</h1>
    <p><strong>ID:</strong> {{ $course->id }}</p>
    <p><strong>Nombre:</strong> {{ $course->name_curso }}</p>
    <p><strong>Descripción:</strong> {{ $course->description }}</p>
    <p><strong>Nivel:</strong> {{ $course->level }}</p>
    <p><strong>Duración:</strong> {{ $course->duracion_horas }} horas</p>
    <p><strong>Área:</strong> {{ $course->area->name ?? 'No asignada' }}</p>
    <p><strong>Centro:</strong> {{ $course->training_center->name ?? 'No asignado' }}</p>
    <p><strong>Docentes:</strong></p>
    <ul>
        @foreach($course->teachers ?? [] as $teacher)
            <li>{{ $teacher->name }}</li>
        @endforeach
    </ul>
    <a href="{{ route('course.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
