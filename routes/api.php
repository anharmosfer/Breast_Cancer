<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\AuthenticationControllerX;
use Illuminate\Support\Facades\Route;







Route::post('register',[AuthenticationController::class, 'register']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/verify',[AuthenticationController::class, 'verify']);
