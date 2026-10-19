@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Mi historial</p>
            <h1>Mis inscripciones</h1>
            <p>Consulta el estado de tus inscripciones.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive bg-white p-4 shadow-sm">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Centro</th>
                    <th>Fecha de inscripción</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->convocatoria->course->name_curso }}</td>
                        <td>{{ $inscripcion->convocatoria->trainingCenter->name }}</td>
                        <td>{{ $inscripcion->enrolled_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge {{ $inscripcion->status === 'Cancelado' ? 'bg-danger' : ($inscripcion->status === 'Aprobado' ? 'bg-primary' : 'bg-success') }}">{{ $inscripcion->status }}</span></td>
                        <td>
                            <a href="{{ route('inscripcion.comprobante', $inscripcion) }}" class="btn btn-sm btn-outline-primary">Comprobante</a>
                            @if($inscripcion->status === 'Inscrito')
                                <form action="{{ route('inscripcion.cancel', $inscripcion) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                </form>
                            @else
                                <span class="text-muted">Sin acciones</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">Aún no tienes inscripciones.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
