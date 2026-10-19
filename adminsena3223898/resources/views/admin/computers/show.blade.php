@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Información del computador</h1>
    <p><strong>ID:</strong> {{ $computer->id }}</p>
    <p><strong>Número:</strong> {{ $computer->numero }}</p>
    <p><strong>Marca:</strong> {{ $computer->marca }}</p>
    <p><strong>Serial:</strong> {{ $computer->serial_num }}</p>
    <a href="{{ route('computer.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
