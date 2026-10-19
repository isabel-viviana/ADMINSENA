@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Editar computador" action="{{ route('computer.update', $computer->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="numero" class="form-label">Número de Computadora</label>
        <input
            type="text"
            name="numero"
            id="numero"
            class="form-control"
            value="{{ $computer->numero }}">
    </div>

    <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input
            type="text"
            name="marca"
            id="marca"
            class="form-control"
            value="{{ $computer->marca }}">
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection
