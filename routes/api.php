<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLecturerController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;

Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('course', CourseController::class);
    
    Route::apiResource('course-lecture', CourseLecturerController::class);
    
    Route::apiResource('enrollment', EnrollmentController::class);
    
    Route::apiResource('lecturer', LecturerController::class);

    Route::apiResource('student', StudentController::class);
});