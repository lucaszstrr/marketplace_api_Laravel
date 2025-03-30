<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    //---------------------------ROTAS RELACIONADAS A ADDRESSES--------------------------------------------------------------
        //Rota para adicionar endereco
        Route::post('/address', [AddressController::class, 'store']);



    //---------------------------ROTAS RELACIONADAS A USUARIOS--------------------------------------------------------------
        //Rota para atualizar o role de usuarios
        Route::post('/updatetitle', [UserController::class, 'update']);



    //---------------------------ROTAS RELACIONADAS A CATEGORIAS------------------------------------------------------------
        //Rota para criar categorias novas
        Route::post('/category', [CategoryController::class, 'store']);
        //Rota para atualizar categorias
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        //Rota para deletar categoria especifica
        Route::delete('/category/{id}', [CategoryController::class, 'delete']);



});

//---------------------------ROTAS RELACIONADAS A USUARIOS------------------------------------------------------------
    //Rota para criar user
    Route::post('/user', [UserController::class, 'store']);
    //Rota para fazer login
    Route::post('/login', [UserController::class, 'login']);



//---------------------------ROTAS RELACIONADAS A CATEGORIAS------------------------------------------------------------
    //Rota para pegar todas as categorias
    Route::get('/categories', [CategoryController::class, 'showAll']);
    //Rota para pegar uma categoria especifica
    Route::get('/category/{id}', [CategoryController::class, 'showOne']);


