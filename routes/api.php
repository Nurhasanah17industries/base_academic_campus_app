<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLectureController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\StudentController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //Akun
    // Route::controller(UserController::class)->group(function(){
    //     Route::get('/user', 'index');
    //     Route::post('/user/store', 'store');
    //     Route::patch('/user/{id}/update', 'update');
    //     Route::get('/user/{id}','show');
    //     Route::delete('/user/{id}', 'destroy');
    // });

    Route::apiResource('student', StudentController::class);
    Route::apiResource('course', CourseController::class);
    Route::apiResource('lecture', LectureController::class);
    Route::apiResource('course-lecture', CourseLectureController::class);
    Route::apiResource('enrolment', EnrollmentController::class);



    // Route::apiResource('customer', CustomerController::class);
    // Route::apiResource('barang', BarangController::class);
    // Route::apiResource('stock', StockController::class);
    // Route::apiResource('order', OrderController::class);
   
});




