
<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;






Route::post('register',[AuthenticationController::class, 'register']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/verify',[AuthenticationController::class, 'verify']);
Route::post('forgot-password', [AuthenticationController::class, 'forgotPassword']);
//Route::post('/reset',[AuthenticationController::class, 'verify']);

Route::group(['middleware' => 'auth:sanctum'], function () {
     Route::post('update-profile',[ProfileController::class, 'update']);
    Route::apiResource('users', UserController::class);
});

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');


//Route::post('reset-password', [AuthenticationController::class, 'reset']);









