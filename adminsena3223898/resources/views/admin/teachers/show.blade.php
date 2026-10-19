@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Información del docente</h1>
    <p><strong>ID:</strong> {{ $teacher->id }}</p>
    <p><strong>Nombre:</strong> {{ $teacher->name }}</p>
    <p><strong>Correo:</strong> {{ $teacher->email }}</p>
    <p><strong>Área:</strong> {{ $teacher->area->name ?? 'No asignada' }}</p>
    <p><strong>Centro:</strong> {{ $teacher->trainingCenter->name ?? 'No asignado' }}</p>
    <p><strong>Cursos que dicta:</strong></p>
    <ul>
        @foreach($teacher->courses as $course)
            <li>{{ $course->name_curso }}</li>
        @endforeach
    </ul>
    <a href="{{ route('teacher.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
