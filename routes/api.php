<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\LectureApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/categories', [CategoryApiController::class, 'index']);

Route::get('/categories/{id}', [CategoryApiController::class, 'show']);

Route::post('/categories', [CategoryApiController::class, 'store']);
Route::put('/categories/{id}', [CategoryApiController::class, 'update']);
Route::delete('/categories/{id}', [CategoryApiController::class, 'destroy']);

// Course API Routes

Route::get('/courses', [CourseApiController::class, 'index']);
Route::get('/courses/{id}', [CourseApiController::class, 'show']);
Route::post('/courses', [CourseApiController::class, 'store']);
Route::put('/courses/{id}', [CourseApiController::class, 'update']);
Route::delete('/courses/{id}', [CourseApiController::class, 'destroy']);

// Lecture API Routes
Route::get('/lectures', [LectureApiController::class, 'index']);
Route::get('/lectures/{id}', [LectureApiController::class, 'show']);
Route::post('/lectures', [LectureApiController::class, 'store']);
Route::put('/lectures/{id}', [LectureApiController::class, 'update']);
Route::delete('/lectures/{id}', [LectureApiController::class, 'destroy']);
Route::get('/lectures/course/{courseId}', [ LectureApiController::class,'byCourse']);
   
    
