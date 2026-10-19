<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\TrainingCenterController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\ApprenticeController;

Route::get('/saludo', function () {
    return response()->json([
        'mensaje' => 'API funcionando correctamente'
    ]);
});

Route::get('/areas', [AreaController::class, 'apiIndex']);
Route::post('/areas', [AreaController::class, 'apiStore']);
Route::get('/areas/{area}', [AreaController::class, 'apiShow']);
Route::put('/areas/{area}', [AreaController::class, 'apiUpdate']);
Route::delete('/areas/{area}', [AreaController::class, 'apiDestroy']);

Route::get('/courses', [CourseController::class, 'apiIndex']);
Route::post('/courses', [CourseController::class, 'apiStore']);
Route::get('/courses/{course}', [CourseController::class, 'apiShow']);
Route::put('/courses/{course}', [CourseController::class, 'apiUpdate']);
Route::delete('/courses/{course}', [CourseController::class, 'apiDestroy']);

Route::get('/training-centers', [TrainingCenterController::class, 'apiIndex']);
Route::post('/training-centers', [TrainingCenterController::class, 'apiStore']);
Route::get('/training-centers/{trainingCenter}', [TrainingCenterController::class, 'apiShow']);
Route::put('/training-centers/{trainingCenter}', [TrainingCenterController::class, 'apiUpdate']);
Route::delete('/training-centers/{trainingCenter}', [TrainingCenterController::class, 'apiDestroy']);

Route::get('/teachers', [TeacherController::class, 'apiIndex']);
Route::post('/teachers', [TeacherController::class, 'apiStore']);
Route::get('/teachers/{teacher}', [TeacherController::class, 'apiShow']);
Route::put('/teachers/{teacher}', [TeacherController::class, 'apiUpdate']);
Route::delete('/teachers/{teacher}', [TeacherController::class, 'apiDestroy']);

Route::get('/computers', [ComputerController::class, 'apiIndex']);
Route::post('/computers', [ComputerController::class, 'apiStore']);
Route::get('/computers/{computer}', [ComputerController::class, 'apiShow']);
Route::put('/computers/{computer}', [ComputerController::class, 'apiUpdate']);
Route::delete('/computers/{computer}', [ComputerController::class, 'apiDestroy']);

Route::get('/apprentices', [ApprenticeController::class, 'apiIndex']);
Route::post('/apprentices', [ApprenticeController::class, 'apiStore']);
Route::get('/apprentices/{apprentice}', [ApprenticeController::class, 'apiShow']);
Route::put('/apprentices/{apprentice}', [ApprenticeController::class, 'apiUpdate']);
Route::delete('/apprentices/{apprentice}', [ApprenticeController::class, 'apiDestroy']);