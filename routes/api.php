<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthController::class, 'validateLogin']);

Route::post('purchase',[TransactionController::class, 'validatePurchase']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::prefix("users")->group(function () {
        Route::post('/create', [UserController::class, 'validateCreate']);
        Route::get('/list', [UserController::class, 'validateList']);
        Route::patch('/update', [UserController::class, 'validateUpdate']);
        Route::delete('/delete/{id}', [UserController::class, 'validateDelete']);
    });

    Route::prefix("products")->group(function () {
        Route::post('/create', [ProductController::class, 'validateCreate']);
        Route::get('/list', [ProductController::class, 'validateList']);
        Route::patch('/update', [ProductController::class, 'validateUpdate']);
        Route::delete('/delete/{id}', [ProductController::class, 'validateDelete']);
    });

    Route::get('transaction/{id}',[TransactionController::class, 'getTransaction']);
    Route::get('transactions',[TransactionController::class, 'getTransactions']);
    
    Route::get('clients',[ClientController::class, 'getClients']);

});

