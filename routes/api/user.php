<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Mobile\Auth\AuthController;
use App\Http\Controllers\Api\Mobile\Auth\OtpController;
use App\Http\Controllers\Api\Mobile\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Mobile\ProfileController;



Route::prefix('api')->group(function () {
Route::post('user/v1/register', [AuthController::class, 'register']);
Route::post('user/v1/auth', [AuthController::class, 'login']);
Route::post('user/v1/send-otp', [OtpController::class, 'SendOtp']);
Route::post('user/v1/validate-otp', [OtpController::class, 'validateOtp']);
Route::post('user/v1/change-password', [ChangePasswordController::class, 'ChnagePassword']);
});


Route::prefix('api')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('user/v1/profile', [ProfileController::class, 'profile']);
         Route::post('user/v1/logout', [AuthController::class, 'logout']);
           Route::delete('user/v1/delete', [ProfileController::class, 'deleteaccount']);
    });



