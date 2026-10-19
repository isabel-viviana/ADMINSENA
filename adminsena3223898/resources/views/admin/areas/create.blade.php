@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Registrar área" action="{{route('area.store')}}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Enviar Formulario</button>
</form>

@endsection