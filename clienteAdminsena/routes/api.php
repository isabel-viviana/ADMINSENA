<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\ApprenticeController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TrainingCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/areas', [AreaController::class, 'apiIndex']);
Route::get('/apprentices', [ApprenticeController::class, 'apiIndex']);
Route::get('/computers', [ComputerController::class, 'apiIndex']);
Route::get('/courses', [CourseController::class, 'apiIndex']);
Route::get('/teachers', [TeacherController::class, 'apiIndex']);
Route::get('/training-centers', [TrainingCenterController::class, 'apiIndex']);