@extends('layouts.app')

@section('content')

<form class="module-form" data-form-title="Registrar computador" action="{{route('computer.store')}}" method="POST" enctype="multipart/form-data">

    @csrf

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="numero" class="form-label">Número de Computadora</label>
        <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}" required>
    </div>

    <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <br>
        <input type="text" name="marca" id="marca" class="form-control" value="{{ old('marca') }}" required>
        <br>
        <input type="file" name="urlFoto" class="form-control-file" accept=".jpg,.jpeg,.png,.webp" required>
        <small class="form-text text-muted">Formatos JPG, PNG o WEBP; máximo 5 MB.</small>

    </div>

    <button type="submit" class="btn btn-primary">Enviar Formulario</button>
    
</form>

@endsection