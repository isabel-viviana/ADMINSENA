@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg bg-white">
                <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #39A900 0%, #39A900 100%);">
                    <div class="module-heading"><span class="module-heading__icon"><i class="fas fa-map-marked-alt" aria-hidden="true"></i></span><div><p class="module-heading__crumb">Administración / Catálogo</p><h4 class="mb-0">Listado de Áreas</h4><p class="module-heading__subtitle">Organiza las áreas de formación.</p></div></div>
                </div>
                <div class="card-body p-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <a href="{{ route('area.create') }}" class="btn btn-primary">Registrar nuevo</a>
                        <form action="{{ route('area.index') }}" method="GET" class="d-flex gap-2">
                            <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por nombre" aria-label="Buscar áreas">
                            <button type="submit" class="btn btn-success">Buscar</button>
                        </form>
                    </div>
                    <table class="table table-bordered mt-4" style="border-radius: 8px; overflow: hidden; margin-bottom: 0;">
                        <thead style="background: linear-gradient(135deg, #71E26B 0%, #39A900 100%); color: white;">
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Área</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($areas as $area)
                                <tr>
                                    <td>{{ $area->id }}</td>
                                    <td>{{ $area->name }}</td>
                                    <td>
                                        <a href="{{ route('area.show', $area->id) }}" class="btn btn-sm btn-info">Ver más</a>
                                        <a href="{{ route('area.edit', $area->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('area.destroy', $area->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este área?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if($areas->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center">No se encontraron resultados.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $areas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection