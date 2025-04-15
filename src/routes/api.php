<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    //ADDRESSES
        Route::post('/address', [AddressController::class, 'store']);
        Route::put('/address/{id}', [AddressController::class, 'update']);
        Route::get('/addresses', [AddressController::class, 'show']);
        Route::get('/addresses/{id}', [AddressController::class, 'showSpecific']);
        Route::delete('/address/{id}', [AddressController::class, 'delete']);


    //USUARIOS
        Route::post('/update-role', [UserController::class, 'update']);
        Route::get('/user', [UserController::class, 'show']);
        Route::get('/user/{id}', [UserController::class, 'showId']);
        Route::get('/users/me', [UserController::class, 'profile']);
        Route::put('/users/me', [UserController::class, 'updateUserLogged']);
        Route::delete('/users/me', [UserController::class, 'userDelete']);


    //CATEGORIAS
        Route::post('/category', [CategoryController::class, 'store']);
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/{id}', [CategoryController::class, 'delete']);


    //PRODUTOS  
        Route::post('/products', [ProductController::class, 'store']);
        Route::delete('/product/{id}', [ProductController::class, 'delete']);
        Route::put('/product/update/{id}', [ProductController::class, 'update']);


    //CARRINHO   
        Route::post('/cart', [CartItemController::class, 'create']);
        Route::get('/cart-items', [CartItemController::class, 'show']);
        Route::get('/cart', [CartItemController::class, 'showCart']);
        Route::put('/cart-items', [CartItemController::class, 'update']);
        Route::post('/cart/items', [CartItemController::class, 'store']);
        Route::delete('/cart-items/{id}', [CartItemController::class, 'delete']);


    //ORDER   
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'show']);
        Route::get('/orders', [OrderController::class, 'showAll']);
        Route::put('/orders/{id}', [OrderController::class, 'updateStatus']);
        Route::delete('/orders/{id}', [OrderController::class, 'delete']);


    //ORDER ITEMS   
        Route::post('/order-items', [OrderItemController::class, 'store']);
        Route::get('/order-items', [OrderItemController::class, 'show']);
        Route::get('/order-items/{id}', [OrderItemController::class, 'showSpecific']);
        Route::delete('/order-items/{id}', [OrderItemController::class, 'delete']);


    //CUPONS   
        Route::post('/coupon', [CouponController::class, 'store']);
        Route::put('/coupon/{id}', [CouponController::class, 'update']);
        Route::get('/coupon', [CouponController::class, 'show']);
        Route::get('/coupon/{id}', [CouponController::class, 'showSpecific']);
        Route::delete('/coupon/{id}', [CouponController::class, 'delete']);


});

//AUTH
Route::post('/user', [AuthController::class, 'create']);
Route::post('/login', [AuthController::class, 'login']);
    

//CATEGORIAS
Route::get('/categories', [CategoryController::class, 'showAll']);
Route::get('/category/{id}', [CategoryController::class, 'showOne']);


//PRODUTOS
Route::get('/products', [ProductController::class, 'show']);
Route::get('/products/{id}', [ProductController::class, 'showId']);

