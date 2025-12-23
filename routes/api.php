<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/customers/trashed', [CustomerController::class, 'trashed']);
Route::resource('customers', CustomerController::class);
Route::post('/customers/{id}/restore', [CustomerController::class, 'restore']);
Route::delete('/customers/{id}/force', [CustomerController::class, 'forceDelete']);

Route::resource('orders', OrderController::class);
Route::get('customers/{customer}/orders',[OrderController::class,'customerOrders']);

Route::post('order-items', [OrderItemController::class, 'store']);
Route::put('order-items/{orderItem}', [OrderItemController::class, 'update']);
Route::delete('order-items/{orderItem}', [OrderItemController::class, 'destroy']);

