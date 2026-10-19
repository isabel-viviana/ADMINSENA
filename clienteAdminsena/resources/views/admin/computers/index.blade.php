@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card border-0 shadow-lg bg-white">
                <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #39A900 0%, #39A900 100%);">
                    <div class="module-heading"><span class="module-heading__icon"><i class="fas fa-desktop" aria-hidden="true"></i></span><div><p class="module-heading__crumb">Administración / Recursos</p><h4 class="mb-0">Listado de Computadores</h4><p class="module-heading__subtitle">Controla el inventario tecnológico.</p></div></div>
                </div>
                <div class="card-body p-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div class="me-3">
                            <h5 class="mb-1">Registro de computadores</h5>
                            <p class="text-secondary mb-0">Consulta y administra los equipos disponibles.</p>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <form action="{{ route('computer.index') }}" method="GET" class="d-flex gap-2">
                                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por número o marca" aria-label="Buscar computadores">
                                <button type="submit" class="btn btn-success">Buscar</button>
                            </form>
                            <a href="{{ route('computer.create') }}" class="btn btn-primary">Registrar nuevo</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered mt-4" style="border-radius: 8px; overflow: hidden; margin-bottom: 0;">
                            <thead style="background: linear-gradient(135deg, #71E26B 0%, #39A900 100%); color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Número</th>
                                    <th>Marca</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($computers as $computer)
                                    <tr>
                                        <td>{{ $computer->id }}</td>
                                        <td>{{ $computer->numero }}</td>
                                        <td>{{ $computer->marca }}</td>
                                        <td><img
                                            src="{{ asset('storage/images/' . $computer->urlFoto) }}"
                                            alt="Imagen del producto"
                                            width="80"
                                            height="80"
                                            style="object-fit: cover; border-radius: 5px;">               </td>
                                        <td>
                                            <a href="{{ route('computer.show', $computer->id) }}" class="btn btn-sm btn-info">Ver más</a>
                                            <a href="{{ route('computer.edit', $computer->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                            <form action="{{ route('computer.destroy', $computer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este computador?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(empty($computers))
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron resultados.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
