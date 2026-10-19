@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Información del centro de formación</h1>
    <p><strong>ID:</strong> {{ $trainingCenter->id }}</p>
    <p><strong>Nombre:</strong> {{ $trainingCenter->name }}</p>
    <p><strong>Localización:</strong> {{ $trainingCenter->location }}</p>
    <a href="{{ route('trainingCenter.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
