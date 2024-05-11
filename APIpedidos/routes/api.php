<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Controlador de productos
Route::get('/productos',[ProductsController::class,'index'])->name('productos.index');



Route::middleware('auth:sanctum')->group(function () 
{
    Route::post('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/productos',[ProductsController::class,'store'])->name('productos.store');
    Route::get('/productos/{id}',[ProductsController::class,'show'])->name('productos.show');
    Route::put('/productos/{id}',[ProductsController::class,'update'])->name('productos.update');
    Route::delete('/productos/{id}',[ProductsController::class,'destroy'])->name('productos.destroy');
});