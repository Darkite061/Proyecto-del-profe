<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteProductoController;

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

// Route::view('/catalogo','/productos.catalogo');
// Route::view('/detalle','/productos.detalle');

Route::get('/productos/catalogo',[ClienteProductoController::class,'catalogo']);
Route::get('/productos/detalle/{id}',[ClienteProductoController::class,'detalle']);
