@extends('layouts.app')

@section('content')
@php
    $adminPrograms = \App\Models\Academic\Course::count();
    $adminOpenCalls = \App\Models\Academic\Intake::where('status', 'Abierta')->count();
    $adminEnrolled = \App\Models\Academic\Enrollment::where('status', 'Inscrito')->distinct('persona_id')->count('persona_id');
    $adminOccupied = \App\Models\Academic\Enrollment::where('status', 'Inscrito')->count();
    $adminRecentCalls = \App\Models\Academic\Intake::with(['course', 'trainingCenter'])->latest('created_at')->take(5)->get();
@endphp
<main class="container py-5">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Panel administrativo</p>
            <h1>Bienvenido, Administrador</h1>
            <p>Gestiona los módulos principales del sistema desde este espacio.</p>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-3"><article class="pillar h-100"><p class="eyebrow">Catálogo</p><h2>{{ $adminPrograms }}</h2><p>Total de Programas de Formación</p></article></div>
        <div class="col-md-3"><article class="pillar h-100"><p class="eyebrow">Oferta</p><h2>{{ $adminOpenCalls }}</h2><p>Convocatorias Abiertas</p></article></div>
        <div class="col-md-3"><article class="pillar h-100"><p class="eyebrow">Registro</p><h2>{{ $adminEnrolled }}</h2><p>Aprendices Inscritos</p></article></div>
        <div class="col-md-3"><article class="pillar h-100"><p class="eyebrow">Ocupación</p><h2>{{ $adminOccupied }}</h2><p>Cupos Ocupados</p></article></div>
    </div>

    <div class="bg-white p-4 mb-5 shadow-sm">
        <h2>Convocatorias más recientes</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Programa</th><th>Centro</th><th>Estado</th><th>Cupos disponibles</th></tr></thead>
                <tbody>
                    @forelse($adminRecentCalls as $recentCall)
                        <tr><td>{{ $recentCall->course->name_curso }}</td><td>{{ $recentCall->trainingCenter->name }}</td><td>{{ $recentCall->status }}</td><td>{{ $recentCall->quota }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No hay convocatorias registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pillar-grid">
        <article class="pillar">
            <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
            <h2>Áreas</h2>
            <p>Administra las áreas de formación.</p>
            <a class="sena-button" href="{{ route('area.index') }}">Ir a Áreas <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-building" aria-hidden="true"></i>
            <h2>Centros de formación</h2>
            <p>Gestiona los centros registrados.</p>
            <a class="sena-button" href="{{ route('trainingCenter.index') }}">Ir a Centros <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-book-open" aria-hidden="true"></i>
            <h2>Programas de formación</h2>
            <p>Administra los cursos disponibles.</p>
            <a class="sena-button" href="{{ route('course.index') }}">Ir a Programas <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
            <h2>Docentes</h2>
            <p>Gestiona la información de los docentes.</p>
            <a class="sena-button" href="{{ route('teacher.index') }}">Ir a Docentes <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-user-graduate" aria-hidden="true"></i>
            <h2>Aprendices</h2>
            <p>Administra los aprendices registrados.</p>
            <a class="sena-button" href="{{ route('apprentice.index') }}">Ir a Aprendices <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-desktop" aria-hidden="true"></i>
            <h2>Computadores</h2>
            <p>Controla el inventario de computadores.</p>
            <a class="sena-button" href="{{ route('computer.index') }}">Ir a Computadores <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
        <article class="pillar">
            <i class="fas fa-bullhorn" aria-hidden="true"></i>
            <h2>Convocatorias</h2>
            <p>Administra las aperturas de los programas.</p>
            <a class="sena-button" href="{{ route('convocatoria.index') }}">Ir a Convocatorias <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        </article>
    </div>
</main>
@endsection
