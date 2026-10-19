<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\ApprenticeController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TrainingCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

$mainAppUrl = str_replace('/api', '', env('URL_SERVER_API'));

Route::redirect('/login', $mainAppUrl . '/login')->name('login');
Route::redirect('/admin', $mainAppUrl . '/admin')->name('admin');

Route::get('/area', [AreaController::class, 'index'])->name('area.index');
Route::get('/area/create', [AreaController::class, 'create'])->name('area.create');
Route::post('/area/store', [AreaController::class, 'store'])->name('area.store');
Route::get('/area/{id}', [AreaController::class, 'show'])->name('area.show');
Route::get('/area/{id}/edit', [AreaController::class, 'edit'])->name('area.edit');
Route::put('/area/update/{id}', [AreaController::class, 'update'])->name('area.update');
Route::delete('/area/delete/{id}', [AreaController::class, 'destroy'])->name('area.destroy');

Route::get('/computer', [ComputerController::class, 'index'])->name('computer.index');
Route::get('/computer/create', [ComputerController::class, 'create'])->name('computer.create');
Route::post('/computer/store', [ComputerController::class, 'store'])->name('computer.store');
Route::get('/computer/{id}', [ComputerController::class, 'show'])->name('computer.show');
Route::get('/computer/{id}/edit', [ComputerController::class, 'edit'])->name('computer.edit');
Route::put('/computer/update/{id}', [ComputerController::class, 'update'])->name('computer.update');
Route::delete('/computer/delete/{id}', [ComputerController::class, 'destroy'])->name('computer.destroy');

Route::get('/trainingCenter', [TrainingCenterController::class, 'index'])->name('trainingCenter.index');
Route::get('/trainingCenter/create', [TrainingCenterController::class, 'create'])->name('trainingCenter.create');
Route::post('/trainingCenter/store', [TrainingCenterController::class, 'store'])->name('trainingCenter.store');
Route::get('/trainingCenter/{id}', [TrainingCenterController::class, 'show'])->name('trainingCenter.show');
Route::get('/trainingCenter/{id}/edit', [TrainingCenterController::class, 'edit'])->name('trainingCenter.edit');
Route::put('/trainingCenter/update/{id}', [TrainingCenterController::class, 'update'])->name('trainingCenter.update');
Route::delete('/trainingCenter/delete/{id}', [TrainingCenterController::class, 'destroy'])->name('trainingCenter.destroy');

Route::get('/apprentice', [ApprenticeController::class, 'index'])->name('apprentice.index');
Route::get('/apprentice/create', [ApprenticeController::class, 'create'])->name('apprentice.create');
Route::post('/apprentice/store', [ApprenticeController::class, 'store'])->name('apprentice.store');
Route::get('/apprentice/{id}', [ApprenticeController::class, 'show'])->name('apprentice.show');
Route::get('/apprentice/{id}/edit', [ApprenticeController::class, 'edit'])->name('apprentice.edit');
Route::put('/apprentice/update/{id}', [ApprenticeController::class, 'update'])->name('apprentice.update');
Route::delete('/apprentice/delete/{id}', [ApprenticeController::class, 'destroy'])->name('apprentice.destroy');

Route::get('/course', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
Route::put('/course/update/{id}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/course/delete/{id}', [CourseController::class, 'destroy'])->name('course.destroy');

Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
Route::get('/teacher/{id}', [TeacherController::class, 'show'])->name('teacher.show');
Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
Route::put('/teacher/update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
Route::delete('/teacher/delete/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
