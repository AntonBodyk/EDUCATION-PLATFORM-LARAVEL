<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExportController;
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
    return view('welcome');

});

Route::post('/send-email', [EmailController::class, 'sendUserEmail'])->name('send-email');

Route::get('/export-users', [ExportController::class, 'exportUsers'])->name('export-users');

Route::view('/email', 'email.users_email')->name('users-email');
Route::view('/admin', 'admin')->name('admin');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


