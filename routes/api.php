
<?php


use App\Http\Controllers\ControlPanelApi\AdminController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;





// Route::middleware('auth:sanctum')->get('user', function (Request $request) {
//     return $request->user();

// });

// Route::post('User',AuthenticationController::class);
Route::get('users', [UserController::class, 'index']);
Route::get('/find/{id}/user',function($id) {
    $criteria = User::find($id)->criteria;
    return $criteria;
});


Route::post('register',[AuthenticationController::class, 'register']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/verify',[AuthenticationController::class, 'verify']);
Route::post('forgot-password', [AuthenticationController::class, 'forgotPassword']);
//Route::post('/reset',[AuthenticationController::class, 'verify']);


Route::group(['middleware' => 'auth:sanctum'], function () {
     Route::post('update-profile',[ProfileController::class, 'update']);
     Route::post('logout',[AuthenticationController::class, 'logout']);
     Route::apiResource('users', AdminController::class);
});


//====================================================================================================



Route::post('/calculate-age-and-store-criteria', [UserController::class, 'calculateAgeAndStoreCriteria']);
Route::get('/show-user-criteria-and-questions', [UserController::class, 'showUserCriteriaAndQuestions']);









Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');












