@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Información del área</h1>
    <p><strong>ID:</strong> {{ $area->id }}</p>
    <p><strong>Nombre:</strong> {{ $area->name }}</p>
    <a href="{{ route('area.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
