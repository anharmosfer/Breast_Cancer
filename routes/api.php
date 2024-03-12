
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









// use App\Http\Controllers\Api\AuthenticationController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// //================================================ 2
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;






// Route::post('/login',[AuthenticationController::class, 'login']);
// Route::post('/registerUser',[AuthenticationController::class, 'registerUser']);
// Route::put('/forgotPassword',[AuthenticationController::class, 'forgotPassword']);


// Route::get( '/users',[AuthenticationController::class, 'get']);


//===================================================================================== 2

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/sanctum/token', function (Request $request) {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//         'device_name' => 'required',
//     ]);

//     $user = User::where('email', $request->email)->first();

//     if (! $user || ! Hash::check($request->password, $user->password)) {
//         throw ValidationException::withMessages([
//             'email' => ['The provided credentials are incorrect.'],
//         ]);
//     }

//     return $user->createToken($request->device_name)->plainTextToken;
// });

// Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
//     $user = $request->user();
//     $user->tokens()->delete();
//     return 'tokens deleted';

// });
