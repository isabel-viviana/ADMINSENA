@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg bg-white">
                <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #39A900 0%, #39A900 100%);">
                    <div class="module-heading"><span class="module-heading__icon"><i class="fas fa-building" aria-hidden="true"></i></span><div><p class="module-heading__crumb">Administración / Catálogo</p><h4 class="mb-0">Listado de Centros de Formación</h4><p class="module-heading__subtitle">Consulta y administra tus centros.</p></div></div>
                </div>
                <div class="card-body p-5">
                    <a href="{{ route('trainingCenter.create') }}" class="btn btn-primary mb-4">Registrar nuevo</a>
                    <table class="table table-bordered mt-4" style="border-radius: 8px; overflow: hidden; margin-bottom: 0;">
                        <thead style="background: linear-gradient(135deg, #71E26B 0%, #39A900 100%); color: white;">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Localización</th>                                <th>Acciones</th>                            </tr>
                        </thead>

                        <tbody>
                            @foreach($trainingCenters as $trainingCenter)
                                <tr>
                                    <td>{{ $trainingCenter->id }}</td>
                                    <td>{{ $trainingCenter->name }}</td>
                                    <td>{{ $trainingCenter->location }}</td>
                                    <td>
                                        <a href="{{ route('trainingCenter.show', $trainingCenter->id) }}" class="btn btn-sm btn-info">Ver más</a>
                                        <a href="{{ route('trainingCenter.edit', $trainingCenter->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('trainingCenter.destroy', $trainingCenter->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este centro de formación?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
