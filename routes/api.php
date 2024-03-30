
<?php


use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\QuestionsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ControlPanelApi\AdminController;
use App\Models\User;
use Illuminate\Support\Facades\Route;






// Route::middleware('auth:sanctum')->get('user', function (Request $request) {
//     return $request->user();

// });

// Route::post('User',AuthenticationController::class);
Route::get('users', [UserController::class, 'index']);


Route::prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('login_with_token', [AuthenticationController::class, 'loginWithToken'])
            ->middleware("auth:sanctum")
            ->name('login_with_token');
        Route::get('logout', [AuthenticationController::class, 'logout'])
            ->middleware("auth:sanctum")
            ->name('logout');
    });

// Route::post('register',[AuthenticationController::class, 'register']);
// Route::post('/login',[AuthenticationController::class, 'login']);
// Route::post('/verify',[AuthenticationController::class, 'verify']);
// Route::post('forgot-password', [AuthenticationController::class, 'forgotPassword']);
//Route::post('/reset',[AuthenticationController::class, 'verify']);


Route::group(['middleware' => 'auth:sanctum'], function () {
     Route::post('update-profile',[ProfileController::class, 'update']);
     Route::post('logout',[AuthenticationController::class, 'logout']);
     Route::apiResource('users', AdminController::class);
});


//====================================================================================================

Route::post('/questions', [QuestionsController::class, 'store']);

Route::get('/show-questions', [UserController::class, 'showQuestions']);










//=========================================================================================================
Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');












