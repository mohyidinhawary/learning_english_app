<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Mobile\Auth\AuthController;
use App\Http\Controllers\Api\Mobile\Auth\OtpController;
use App\Http\Controllers\Api\Mobile\Auth\ChangePasswordController;
use App\Http\Controllers\Api\Mobile\ProfileController;
use App\Http\Controllers\Api\Mobile\LessonController;
use App\Http\Controllers\Api\Mobile\ExerciesController;
use App\Http\Controllers\Api\Mobile\FeedbackController;
use App\Http\Controllers\Api\Mobile\ChapterController;
use App\Http\Controllers\Api\Mobile\OnboardingController;
use App\Http\Controllers\Api\Mobile\IssueReportController;
Route::prefix('api')->group(function () {
Route::post('user/v1/register', [AuthController::class, 'register']);
Route::post('user/v1/onboarding', [OnboardingController::class, 'store']);
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
               Route::get('user/v1/chapter-lessons/{id}', [LessonController::class, 'showchapterlessons']);
               Route::get('user/v1/exercies/{id}', [ExerciesController::class, 'showexercies']);
               Route::post('user/v1/answer-exercies/{id}', [ExerciesController::class, 'answerexercies']);
               Route::get('user/v1/lesson-words/{id}', [LessonController::class, 'showlessonwords']);
               Route::get('user/v1/lesson-sentences/{id}', [LessonController::class, 'showlessonsentence']);
                Route::get('user/v1/word/{id}', [LessonController::class, 'showword']);
                Route::get('user/v1/sentence/{id}', [LessonController::class, 'showsentence']);
                Route::get('user/v1/review-mistakes/{id}', [LessonController::class, 'reviewMistakes']);
                Route::get('user/v1/earned-xp/{id}', [LessonController::class, 'finalizeLesson']);
                Route::post('user/v1/send-feedback', [FeedbackController::class, 'sendfeedback']);
                Route::get('user/v1/earned-badges/{id}', [ChapterController::class, 'finalizeChapter']);
                Route::get('user/v1/word-exercies/{id}', [ExerciesController::class, 'wordExercises']);
                Route::get('user/v1/user-streak', [ExerciesController::class, 'showuserstreak']);
                  Route::get('user/v1/lesson-exercieses/{id}', [LessonController::class, 'showlessonexerciesies']);
                   Route::post('user/v1/issue-reports', [IssueReportController::class, 'store']);
    Route::get('user/v1/issue-reports', [IssueReportController::class, 'index']);
    });



