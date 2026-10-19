@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg bg-white">
                <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #39A900 0%, #39A900 100%);">
                    <div class="module-heading"><span class="module-heading__icon"><i class="fas fa-book-open" aria-hidden="true"></i></span><div><p class="module-heading__crumb">Administración / Catálogo</p><h4 class="mb-0">Programas de Formación</h4><p class="module-heading__subtitle">Consulta y administra la oferta institucional.</p></div></div>
                </div>
                <div class="card-body p-5">
                    <a href="{{ route('course.create') }}" class="btn btn-primary mb-4">Registrar programa</a>
                    <table class="table table-bordered mt-4" style="border-radius: 8px; overflow: hidden; margin-bottom: 0;">
                        <thead style="background: linear-gradient(135deg, #71E26B 0%, #39A900 100%); color: white;">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Área</th>
                                <th>Centro</th>
                                <th>Nivel</th>
                                <th>Duración</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->name_curso }}</td>
                                    <td>{{ $course->area->name }}</td>
                                    <td>{{ $course->training_center->name }}</td>
                                    <td>{{ $course->level }}</td>
                                    <td>{{ $course->duration }} meses</td>
                                    <td><img
                                            src="{{ asset('storage/images/' . $course->urlFoto) }}"
                                            alt="Imagen del producto"
                                            width="80"
                                            height="80"
                                            style="object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('course.show', $course->id) }}" class="btn btn-sm btn-info">Ver más</a>
                                        <a href="{{ route('course.edit', $course->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('course.destroy', $course->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este programa?')">Eliminar</button>
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
