<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExelMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('admin');
})->name('admin');

Route::post('/send-email', [EmailController::class, 'sendUserEmail'])->name('send-email')->middleware('auth', 'admin');

Route::get('/export-users', [ExportController::class, 'exportUsers'])->name('export-users')->middleware('auth', 'admin');

Route::view('/email', 'email.users_email')->name('users-email')->middleware('auth', 'admin');


Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('admin', 'auth');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('auth', 'admin');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth', 'admin');
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('auth');
Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth', 'admin');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth', 'admin');


Route::get('/courses', [CourseController::class, 'index'])->name('courses.index')->middleware('auth', 'admin');
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create')->middleware('auth', 'admin');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit')->middleware('auth', 'admin');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store')->middleware('auth', 'admin');
Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('courses.update')->middleware('auth', 'admin');
Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy')->middleware('auth', 'admin');
