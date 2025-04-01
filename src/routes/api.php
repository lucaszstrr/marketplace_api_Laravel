<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    //---------------------------ROTAS RELACIONADAS A ADDRESSES-------------------------------
        //Rota para adicionar endereco
        Route::post('/address', [AddressController::class, 'store']);
        //Rota para atualizar endereco do usuario logado
        Route::put('/address/{id}', [AddressController::class, 'update']);
        //Rota para pegar todos os address do usuario logado
        Route::get('/addresses', [AddressController::class, 'show']);
        //Rota para address especifico do usuario logado
        Route::get('/addresses/{id}', [AddressController::class, 'showSpecific']);



    //---------------------------ROTAS RELACIONADAS A USUARIOS-------------------------------
        //Rota para atualizar o role de usuarios
        Route::post('/updatetitle', [UserController::class, 'update']);
        //Mostrar todos os user
        Route::get('/user', [UserController::class, 'show']);
        //Mostrar user especifico
        Route::get('/user/{id}', [UserController::class, 'showId']);
        //Ver perfil logado
        Route::get('/users/me', [UserController::class, 'profile']);
        //Atualizar user logado
        Route::put('/users/me', [UserController::class, 'updateUserLogged']);
        //Delete o user logado
        Route::delete('/users/me', [UserController::class, 'userDelete']);


    //---------------------------ROTAS RELACIONADAS A CATEGORIAS-----------------------------
        //Rota para criar categorias novas
        Route::post('/category', [CategoryController::class, 'store']);
        //Rota para atualizar categorias
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        //Rota para deletar categoria especifica
        Route::delete('/category/{id}', [CategoryController::class, 'delete']);


    //---------------------------ROTAS RELACIONADAS A PRODUTOS-------------------------------       
        //Rota para criar novos produtos
        Route::post('/products', [ProductController::class, 'store']);
        //Rota para deletar produto especifico
        Route::delete('/product/{id}', [ProductController::class, 'delete']);
        //Rota para atualizar produto
        Route::put('/product/update/{id}', [ProductController::class, 'update']);

});

//---------------------------ROTAS RELACIONADAS A USUARIOS-----------------------------
    //Rota para criar user
    Route::post('/user', [UserController::class, 'store']);
    //Rota para fazer login
    Route::post('/login', [UserController::class, 'login']);
    



//---------------------------ROTAS RELACIONADAS A CATEGORIAS---------------------------
    //Rota para pegar todas as categorias
    Route::get('/categories', [CategoryController::class, 'showAll']);
    //Rota para pegar uma categoria especifica
    Route::get('/category/{id}', [CategoryController::class, 'showOne']);


//---------------------------ROTAS RELACIONADAS A PRODUTOS-----------------------------
    //Mostrar todos os produtos
    Route::get('/products', [ProductController::class, 'show']);
    //Mostrar produto especifico
    Route::get('/products/{id}', [ProductController::class, 'showId']);

