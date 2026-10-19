<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controladores de Administración
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\TrainingCenterController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ApprenticeController;
use App\Http\Controllers\Admin\IntakeController as ConvocatoriaController;

// Controladores de Aprendiz
use App\Http\Controllers\Apprentice\PortalController as ApprenticePortalController;

// Controladores de Aspirante / Portal Público
use App\Http\Controllers\Aspirant\EnrollmentController as InscripcionController;

// Controladores de Autenticación y Sistema
use App\Http\Controllers\System\AuthController;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS / INICIO
|--------------------------------------------------------------------------
*/
Route::get('/', function (Request $request) {
	$query = trim((string) $request->query('q', ''));

	if ($query === '') {
		return view('dashboard');
	}

	$normalizedQuery = mb_strtolower($query, 'UTF-8');
	$destinations = [
		['label' => 'Inicio', 'url' => route('home'), 'keywords' => ['inicio', 'home', 'portal']],
		['label' => '¿Quiénes somos?', 'url' => route('home').'#conocenos', 'keywords' => ['quienes', 'quiénes', 'somos', 'empresa', 'mision', 'misión']],
		['label' => 'Contáctanos', 'url' => route('home').'#contacto', 'keywords' => ['contacto', 'contáctanos', 'telefono', 'teléfono', 'celular']],
		['label' => 'Áreas', 'url' => route('area.index'), 'keywords' => ['area', 'área', 'areas', 'áreas', 'administracion', 'administración', 'admin']],
		['label' => 'Centros de formación', 'url' => route('trainingCenter.index'), 'keywords' => ['centro', 'centros', 'formacion', 'formación', 'administracion', 'administración', 'admin']],
		['label' => 'Computadores', 'url' => route('computer.index'), 'keywords' => ['computador', 'computadores', 'equipo', 'equipos', 'administracion', 'administración', 'admin']],
		['label' => 'Docentes', 'url' => route('teacher.index'), 'keywords' => ['docente', 'docentes', 'profesor', 'profesores', 'administracion', 'administración', 'admin']],
		['label' => 'Cursos', 'url' => route('course.index'), 'keywords' => ['curso', 'cursos', 'formacion', 'formación', 'administracion', 'administración', 'admin']],
		['label' => 'Aprendices', 'url' => route('apprentice.index'), 'keywords' => ['aprendiz', 'aprendices', 'estudiante', 'estudiantes', 'administracion', 'administración', 'admin']],
	];

	$matches = array_values(array_filter($destinations, function (array $destination) use ($normalizedQuery) {
		return array_reduce($destination['keywords'], function (bool $found, string $keyword) use ($normalizedQuery) {
			$normalizedKeyword = mb_strtolower($keyword, 'UTF-8');

			return $found || str_contains($normalizedKeyword, $normalizedQuery) || str_contains($normalizedQuery, $normalizedKeyword);
		}, false);
	}));

	if (count($matches) === 1) {
		return redirect($matches[0]['url']);
	}

	return view('dashboard', [
		'searchQuery' => $query,
		'searchResults' => $matches,
		'searchMessage' => $matches === [] ? 'No se encontraron resultados' : null,
	]);
})->name('home');

/*
|--------------------------------------------------------------------------
| 2. RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
	return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. RUTAS DE ADMINISTRACIÓN (ADMIN)
|--------------------------------------------------------------------------
*/
Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');

// Áreas
Route::get('/area', [AreaController::class, 'index'])->name('area.index');
Route::get('/area/create', [AreaController::class, 'create'])->name('area.create');
Route::post('/area/store', [AreaController::class, 'store'])->name('area.store');
Route::get('/area/show/{area}', [AreaController::class, 'show'])->name('area.show');
Route::get('/area/edit/{area}', [AreaController::class, 'edit'])->name('area.edit');
Route::put('/area/update/{area}', [AreaController::class, 'update'])->name('area.update');
Route::delete('/area/delete/{area}', [AreaController::class, 'destroy'])->name('area.destroy');

// Computadores / Equipos
Route::get('/computer', [ComputerController::class, 'index'])->name('computer.index');
Route::get('/computer/create', [ComputerController::class, 'create'])->name('computer.create');
Route::post('/computer/store', [ComputerController::class, 'store'])->name('computer.store');
Route::get('/computer/show/{computer}', [ComputerController::class, 'show'])->name('computer.show');
Route::get('/computer/edit/{computer}', [ComputerController::class, 'edit'])->name('computer.edit');
Route::put('/computer/update/{computer}', [ComputerController::class, 'update'])->name('computer.update');
Route::delete('/computer/delete/{computer}', [ComputerController::class, 'destroy'])->name('computer.destroy');

// Centros de Formación
Route::get('/trainingCenter', [TrainingCenterController::class, 'index'])->name('trainingCenter.index');
Route::get('/trainingCenter/create', [TrainingCenterController::class, 'create'])->name('trainingCenter.create');
Route::post('/trainingCenter/store', [TrainingCenterController::class, 'store'])->name('trainingCenter.store');
Route::get('/trainingCenter/show/{trainingCenter}', [TrainingCenterController::class, 'show'])->name('trainingCenter.show');
Route::get('/trainingCenter/edit/{trainingCenter}', [TrainingCenterController::class, 'edit'])->name('trainingCenter.edit');
Route::put('/trainingCenter/update/{trainingCenter}', [TrainingCenterController::class, 'update'])->name('trainingCenter.update');
Route::delete('/trainingCenter/delete/{trainingCenter}', [TrainingCenterController::class, 'destroy'])->name('trainingCenter.destroy');

// Docentes / Instructores
Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
Route::get('/teacher/show/{teacher}', [TeacherController::class, 'show'])->name('teacher.show');
Route::get('/teacher/edit/{teacher}', [TeacherController::class, 'edit'])->name('teacher.edit');
Route::put('/teacher/update/{teacher}', [TeacherController::class, 'update'])->name('teacher.update');
Route::delete('/teacher/delete/{teacher}', [TeacherController::class, 'destroy'])->name('teacher.destroy');

// Cursos
Route::get('/course', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
Route::get('/course/show/{course}', [CourseController::class, 'show'])->name('course.show');
Route::get('/course/edit/{course}', [CourseController::class, 'edit'])->name('course.edit');
Route::put('/course/update/{course}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/course/delete/{course}', [CourseController::class, 'destroy'])->name('course.destroy');

// Gestión de Aprendices (CRUD Administrador)
Route::get('/apprentice', [ApprenticeController::class, 'index'])->name('apprentice.index');
Route::get('/apprentice/create', [ApprenticeController::class, 'create'])->name('apprentice.create');
Route::post('/apprentice/store', [ApprenticeController::class, 'store'])->name('apprentice.store');
Route::get('/apprentice/show/{apprentice}', [ApprenticeController::class, 'show'])->name('apprentice.show');
Route::get('/apprentice/edit/{apprentice}', [ApprenticeController::class, 'edit'])->name('apprentice.edit');
Route::put('/apprentice/update/{apprentice}', [ApprenticeController::class, 'update'])->name('apprentice.update');
Route::delete('/apprentice/delete/{apprentice}', [ApprenticeController::class, 'destroy'])->name('apprentice.destroy');

// Convocatorias (CRUD Administrador y Gestión)
Route::get('/convocatorias', [ConvocatoriaController::class, 'index'])->name('convocatoria.index');
Route::get('/convocatorias/create', [ConvocatoriaController::class, 'create'])->name('convocatoria.create');
Route::post('/convocatorias', [ConvocatoriaController::class, 'store'])->name('convocatoria.store');
Route::get('/convocatorias/{convocatoria}/edit', [ConvocatoriaController::class, 'edit'])->name('convocatoria.edit');
Route::put('/convocatorias/{convocatoria}', [ConvocatoriaController::class, 'update'])->name('convocatoria.update');
Route::get('/admin/convocatorias/{convocatoria}', [ConvocatoriaController::class, 'adminStats'])->name('admin.convocatoria.stats');
Route::get('/convocatorias/{convocatoria}/inscritos', [InscripcionController::class, 'inscritos'])->name('convocatoria.inscritos');
Route::patch('/admin/inscripciones/{inscripcion}/estado', [InscripcionController::class, 'updateStatus'])->name('inscripcion.update-status');

/*
|--------------------------------------------------------------------------
| 4. RUTAS DEL PORTAL DE APRENDIZ (APPRENTICE)
|--------------------------------------------------------------------------
*/
Route::get('/portal', [ApprenticePortalController::class, 'index'])->name('portal');

/*
|--------------------------------------------------------------------------
| 5. RUTAS DE ASPIRANTE / CONVOCATORIAS E INSCRIPCIONES (ASPIRANT)
|--------------------------------------------------------------------------
*/
Route::get('/portal/convocatorias', [ConvocatoriaController::class, 'catalog'])->name('portal.convocatorias');
Route::get('/portal/convocatorias/{convocatoria}', [ConvocatoriaController::class, 'detail'])->name('portal.convocatoria.detail');
Route::get('/portal/mis-inscripciones', [InscripcionController::class, 'misInscripciones'])->name('portal.mis-inscripciones');
Route::get('/mis-inscripciones/{inscripcion}/comprobante', [InscripcionController::class, 'comprobante'])->name('inscripcion.comprobante');
Route::post('/convocatorias/{convocatoria}/inscribirme', [InscripcionController::class, 'store'])->name('inscripcion.store');
Route::patch('/mis-inscripciones/{inscripcion}/cancelar', [InscripcionController::class, 'cancel'])->name('inscripcion.cancel');
