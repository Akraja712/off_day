<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/customer-details', [AuthController::class, 'customerdetails']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
