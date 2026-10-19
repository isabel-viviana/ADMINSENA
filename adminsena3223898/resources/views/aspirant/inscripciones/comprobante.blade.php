@extends('layouts.app')

@section('content')
<style>
    @media print {
        .sena-navbar,
        .sena-footer,
        .print-hidden {
            display: none !important;
        }

        .receipt {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }
</style>

<div class="container my-5">
    <div class="receipt bg-white border shadow-sm mx-auto" style="max-width: 820px;">
        <div class="p-4 text-white" style="background: linear-gradient(135deg, #39A900 0%, #087830 100%);">
            <p class="mb-2 text-uppercase small">Servicio Nacional de Aprendizaje</p>
            <h1 class="h3 mb-0">Comprobante de inscripción</h1>
        </div>

        <div class="p-4 p-lg-5">
            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                <div>
                    <p class="text-muted mb-1">Código de inscripción</p>
                    <h2 class="h4 mb-0">{{ sprintf('INS-%06d', $inscripcion->id) }}</h2>
                </div>
                <div class="text-md-end">
                    <p class="text-muted mb-1">Estado actual</p>
                    <span class="badge {{ $inscripcion->status === 'Cancelado' ? 'bg-danger' : ($inscripcion->status === 'Aprobado' ? 'bg-primary' : 'bg-success') }}">{{ $inscripcion->status }}</span>
                </div>
            </div>

            <h2 class="h5 border-bottom pb-2">Datos del aprendiz</h2>
            <dl class="row mb-4">
                <dt class="col-sm-4">Nombre</dt>
                <dd class="col-sm-8">{{ $inscripcion->user->name }}</dd>
                <dt class="col-sm-4">Documento</dt>
                <dd class="col-sm-8">{{ $inscripcion->user->document ?? 'No disponible' }}</dd>
                <dt class="col-sm-4">Correo</dt>
                <dd class="col-sm-8">{{ $inscripcion->user->email }}</dd>
            </dl>

            <h2 class="h5 border-bottom pb-2">Programa de formación</h2>
            <dl class="row mb-4">
                <dt class="col-sm-4">Programa</dt>
                <dd class="col-sm-8">{{ $inscripcion->convocatoria->course->name_curso }}</dd>
                <dt class="col-sm-4">Centro</dt>
                <dd class="col-sm-8">{{ $inscripcion->convocatoria->trainingCenter->name }}</dd>
                <dt class="col-sm-4">Jornada</dt>
                <dd class="col-sm-8">{{ $inscripcion->convocatoria->schedule }}</dd>
                <dt class="col-sm-4">Modalidad</dt>
                <dd class="col-sm-8">{{ $inscripcion->convocatoria->modality }}</dd>
                <dt class="col-sm-4">Fecha de inicio</dt>
                <dd class="col-sm-8">{{ $inscripcion->convocatoria->start_date->format('d/m/Y') }}</dd>
            </dl>

            <h2 class="h5 border-bottom pb-2">Registro</h2>
            <dl class="row mb-4">
                <dt class="col-sm-4">Fecha de inscripción</dt>
                <dd class="col-sm-8">{{ $inscripcion->enrolled_at->format('d/m/Y H:i') }}</dd>
                <dt class="col-sm-4">Código</dt>
                <dd class="col-sm-8">{{ sprintf('INS-%06d', $inscripcion->id) }}</dd>
            </dl>

            <div class="d-flex gap-2 print-hidden">
                <button type="button" class="btn btn-success" onclick="window.print()">Imprimir</button>
                <a href="{{ route('portal.mis-inscripciones') }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
