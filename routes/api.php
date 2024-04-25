<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('checkregistered', [AuthController::class, 'checkregistered']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/customer-details', [AuthController::class, 'customerdetails']);
Route::post('shop-login', [AuthController::class, 'shoplogin']);
Route::post('shop-register', [AuthController::class, 'shopregister']);
Route::post('/shop-details', [AuthController::class, 'shopdetails']);
Route::post('/add-offer', [AuthController::class, 'addoffers']);
Route::post('/edit-offer', [AuthController::class, 'editoffers']);
Route::post('/delete-offer', [AuthController::class, 'deleteoffers']);
Route::post('/offer-details', [AuthController::class, 'offerdetails']);
Route::post('/offer-locked', [AuthController::class, 'offerlocked']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
