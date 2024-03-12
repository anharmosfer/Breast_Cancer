
<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\AuthenticationControllerX;
use Illuminate\Support\Facades\Route;







Route::post('register',[AuthenticationController::class, 'register']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/verify',[AuthenticationController::class, 'verify']);


Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);









