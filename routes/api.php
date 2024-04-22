<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/customer-details', [AuthController::class, 'customerdetails']);
Route::post('shoplogin', [AuthController::class, 'shoplogin']);
Route::post('shopregister', [AuthController::class, 'shopregister']);
Route::post('/shop-details', [AuthController::class, 'shopdetails']);
Route::post('/add-offer', [AuthController::class, 'addoffers']);
Route::post('/edit-offer', [AuthController::class, 'editoffers']);
Route::post('/offer-details', [AuthController::class, 'offerdetails']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
