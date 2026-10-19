@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Editar área" action="{{ route('area.update', $area->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            value="{{ $area->name }}">
    </div>

    <button type="submit" class="btn btn-primary">
        Actualizar
    </button>

</form>

@endsection