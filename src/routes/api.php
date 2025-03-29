<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    //Rota para adicionar endereco
    Route::post('/address', [AddressController::class, 'store']);
    //Rota para atualizar o role de usuarios
    Route::post('/updatetitle', [UserController::class, 'update']);
});

//Rota para criar user
Route::post('/user', [UserController::class, 'store']);

//Rota para fazer login
Route::post('/login', [UserController::class, 'login']);

//Rota para adicionar endereco
//Route::post('/adress', [AddressController::class, 'store']);


//rota teste
//Route::post('/teste', [AddressController::class,'index']);

