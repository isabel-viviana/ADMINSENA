@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Editar centro de formación" action="{{ route('trainingCenter.update', $trainingCenter->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            value="{{ $trainingCenter->name }}">
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Localización</label>
        <input
            type="text"
            name="location"
            id="location"
            class="form-control"
            value="{{ $trainingCenter->location }}">
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection
