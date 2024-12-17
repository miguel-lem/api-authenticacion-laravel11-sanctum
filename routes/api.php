<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//rutas para inicio de sesion
Route::get('/products',[ProductController::class,'index']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


//grupo de rutas protegidas
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout',[AuthController::class,'logout']);
    Route::get('/products',[ProductController::class,'index']);
    Route::post('/create',[ProductController::class,'create']);
    Route::get('/show/{id}',[ProductController::class,'show']);
    Route::delete('/delete/{id}',[ProductController::class,'delete']);
    Route::post('/update/{id}',[ProductController::class,'update']);
});


