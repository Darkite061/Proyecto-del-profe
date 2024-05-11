<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::resource('projects', ProjectController::class);



Route::get('login', [UserAuthController::class, 'login'])->name('user.login');
Route::get('out', [UserAuthController::class, 'out'])->name('user.out')->middleware('sesion');
Route::post('auth', [UserAuthController::class, 'auth'])->name('user.auth');
Route::post('register', [UserAuthController::class, 'register'])->name('user.register');

Route::resource('posts', PostController::class)->middleware('sesion');
