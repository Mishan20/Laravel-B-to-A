<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student', [StudentController::class, 'index']);

//load create form
Route::get('/student/create', [StudentController::class, 'create']);
Route::post('/student/create', [StudentController::class, 'save']);

//load the edit form
Route::get('/student/edit/{id}', [StudentController::class, 'edit']);
Route::post('/student/edit/{id}', [StudentController::class, 'update']);