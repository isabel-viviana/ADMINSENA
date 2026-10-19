@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Convocatoria</p>
            <h1>Aprendices inscritos</h1>
            <p>{{ $convocatoria->course->name_curso }} | {{ $convocatoria->trainingCenter->name }}</p>
        </div>
    </div>

    <div class="table-responsive bg-white p-4 shadow-sm">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Nombre del aprendiz</th>
                    <th>Correo</th>
                    <th>Fecha de inscripción</th>
                    <th>Estado</th>
                    <th>Actualizar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->user->name }}</td>
                        <td>{{ $inscripcion->user->email }}</td>
                        <td>{{ $inscripcion->enrolled_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge {{ $inscripcion->status === 'Cancelado' ? 'bg-danger' : ($inscripcion->status === 'Aprobado' ? 'bg-primary' : 'bg-success') }}">{{ $inscripcion->status }}</span></td>
                        <td>
                            <form action="{{ route('inscripcion.update-status', $inscripcion) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" aria-label="Nuevo estado">
                                    @foreach(['Inscrito', 'Aprobado', 'Cancelado'] as $status)
                                        <option value="{{ $status }}" {{ $inscripcion->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">No hay aprendices inscritos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
