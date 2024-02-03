<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\RatingController;


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

Route::resources([
    'roles'=> RoleController::class,
    'users'=> UserController::class,
    'categories'=> CategoryController::class,
    'courses'=> CourseController::class
]);
