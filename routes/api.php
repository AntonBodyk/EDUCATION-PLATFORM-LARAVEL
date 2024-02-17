<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollCourseController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/courses/search', [CourseController::class, 'search']);
Route::get('/categories/{category}/courses', [CategoryController::class, 'getCoursesByCategory']);
Route::post('/courses/{courseId}/rate', [RatingController::class, 'rateCourse']);
Route::get('/courses/{id}/lessons', [CourseController::class, 'lessons']);
Route::post('/generate-report', [ReportController::class, 'generateReport']);

Route::resources([
    'roles'=> RoleController::class,
    'users'=> UserController::class,
    'categories'=> CategoryController::class,
    'courses'=> CourseController::class,
    'lessons'=> LessonController::class,
    'enroll-courses' => EnrollCourseController::class
]);
