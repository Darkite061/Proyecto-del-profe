<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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
Route::view('/cover','/cover/index');
Route::view('/product','/product/index');



// Route::view('/admin/plantilla','/admin/plantilla/layout');
// Route::view('/admin/categorias','/admin/categorias/list');
// Route::view('/admin/categorias/crear','/admin/categorias/create');

Route::get('/categorias',[CategoryController::class, 'indice']);
Route::get('/categorias/crear',[CategoryController::class,'crear']);
Route::post('/categorias',[CategoryController::class,'guardar']);
Route::get('/categorias/editar/{id}',[CategoryController::class,'editar']);
Route::put('/categorias/{id}',[CategoryController::class,'actualizar']);
Route::get('/categorias/mostrar/{id}',[CategoryController::class,'mostrar']);
Route::delete('/categorias/{id}',[CategoryController::class,'borrar']);


Route::get('/productos',[ProductController::class, 'index'])->name('productos.index');
Route::get('/productos/crear',[ProductController::class,'create'])->name('productos.create');
Route::post('/productos',[ProductController::class,'store'])->name('productos.store');
Route::get('/productos/{id}/edit',[ProductController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{id}',[ProductController::class,'update'])->name('productos.update');
Route::get('/productos/{id}',[ProductController::class, 'show'])->name('productos.show');
Route::delete('/productos/{id}',[ProductController::class,'destroy'])->name('productos.destroy');

Route::get('/login',[AuthController::class, 'login'])->name('auth.login');
Route::post('/autenticate',[AuthController::class, 'autenticate'])->name('auth.autenticate');
Route::post('/logout',[AuthController::class, 'logout'])->name('auth.logout');