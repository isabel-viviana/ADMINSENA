@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Información del aprendiz</h1>
    <p><strong>ID:</strong> {{ $apprentice->id }}</p>
    <p><strong>Nombre:</strong> {{ $apprentice->name_apren }}</p>
    <p><strong>Correo:</strong> {{ $apprentice->email }}</p>
    <p><strong>Celular:</strong> {{ $apprentice->cell }}</p>
    <p><strong>Curso:</strong> {{ $apprentice->course->name_curso ?? 'No asignado' }}</p>
    <p><strong>Computador:</strong> {{ $apprentice->computer->numero ?? 'No asignado' }}</p>
    <a href="{{ route('apprentice.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
