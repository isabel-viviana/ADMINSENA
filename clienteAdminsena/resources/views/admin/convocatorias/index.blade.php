@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-xxl-11">
            <div class="card border-0 shadow-lg bg-white">
                <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #39A900 0%, #087830 100%);">
                    <div class="module-heading"><span class="module-heading__icon"><i class="fas fa-bullhorn" aria-hidden="true"></i></span><div><p class="module-heading__crumb">Administración / Oferta</p><h4 class="mb-0">Convocatorias</h4><p class="module-heading__subtitle">Gestiona las aperturas de los Programas de Formación.</p></div></div>
                </div>
                <div class="card-body p-4 p-lg-5">
                    @if(isset($stats))
                        <div class="row g-3 mb-4">
                            <div class="col-md-3"><div class="p-3 border rounded"><small>Total de cupos</small><h3 class="mb-0">{{ $stats['total'] }}</h3></div></div>
                            <div class="col-md-3"><div class="p-3 border rounded"><small>Inscritos</small><h3 class="mb-0">{{ $stats['inscritos'] }}</h3></div></div>
                            <div class="col-md-3"><div class="p-3 border rounded"><small>Disponibles</small><h3 class="mb-0">{{ $stats['disponibles'] }}</h3></div></div>
                            <div class="col-md-3"><div class="p-3 border rounded"><small>Ocupación</small><h3 class="mb-0">{{ $stats['porcentaje'] }}%</h3></div></div>
                        </div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <p class="mb-0">Gestiona las aperturas de los Programas de Formación.</p>
                        <a href="{{ route('convocatoria.create') }}" class="btn btn-primary">Crear convocatoria</a>
                    </div>

                    <form method="GET" action="{{ route('convocatoria.index') }}" class="row g-2 mb-4">
                        <div class="col-md-8">
                            <label for="q" class="visually-hidden">Buscar convocatoria</label>
                            <input type="search" name="q" id="q" class="form-control" value="{{ $query }}" placeholder="Buscar por programa o centro">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-outline-success">Buscar</button>
                            @if($query !== '')
                                <a href="{{ route('convocatoria.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead style="background: linear-gradient(135deg, #71E26B 0%, #39A900 100%); color: white;">
                                <tr>
                                    <th>Programa</th>
                                    <th>Centro</th>
                                    <th>Jornada</th>
                                    <th>Modalidad</th>
                                    <th>Cupos</th>
                                    <th>Estado</th>
                                    <th>Fecha inicio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($convocatorias as $convocatoria)
                                    <tr>
                                        <td>{{ $convocatoria->course->name_curso }}</td>
                                        <td>{{ $convocatoria->trainingCenter->name }}</td>
                                        <td>{{ $convocatoria->schedule }}</td>
                                        <td>{{ $convocatoria->modality }}</td>
                                        <td>{{ $convocatoria->quota }}</td>
                                        <td>
                                            <span class="badge {{ $convocatoria->status === 'Abierta' ? 'bg-success' : ($convocatoria->status === 'Cerrada' ? 'bg-danger' : 'bg-secondary') }}">{{ $convocatoria->status }}</span>
                                            @if($convocatoria->quota < 1 && $convocatoria->status === 'Abierta')
                                                <span class="badge bg-danger">Cupos agotados</span>
                                            @endif
                                        </td>
                                        <td>{{ $convocatoria->start_date->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('convocatoria.edit', $convocatoria) }}" class="btn btn-sm btn-warning">Editar</a>
                                            <a href="{{ route('convocatoria.inscritos', $convocatoria) }}" class="btn btn-sm btn-outline-success">Ver inscritos</a>
                                            <a href="{{ route('admin.convocatoria.stats', $convocatoria) }}" class="btn btn-sm btn-outline-primary">Estadísticas</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center py-4">No hay convocatorias registradas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $convocatorias->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
