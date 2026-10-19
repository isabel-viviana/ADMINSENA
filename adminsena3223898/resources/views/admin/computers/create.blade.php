@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Registrar computador" action="{{route('computer.store')}}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label for="numero" class="form-label">Número de Computadora</label>
        <input type="text" name="numero" id="numero" class="form-control">
    </div>

    <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <br>
        <input type="text" name="marca" id="marca" class="form-control">
        <br>
        <input type="file" name="urlFoto" class="form-control-file" accept="image/*">

    </div>

    <button type="submit" class="btn btn-primary">Enviar Formulario</button>
    
</form>

@endsection