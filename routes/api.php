<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ApprovedController;
use App\Http\Controllers\CompanyProfile;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Middleware\CheckXToken;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'list']);
        Route::get('/me', [UserController::class, 'me']);
        Route::put('/me', [UserController::class, 'update']);
        Route::delete('/me', [UserController::class, 'destroy']);
    });
    // Company
    Route::post('/update/company/{id}', [CompanyProfile::class, 'update']);
    Route::post('/store/company', [CompanyProfile::class, 'store']);
    // about

    Route::post('/about', [AboutUsController::class, 'store']);
    Route::post('/about/update/{id}', [AboutUsController::class, 'update']);
    // Certificate

    Route::post('/inspect', [InspectionController::class, 'store']);
    Route::post('/inspect/update/{id}', [InspectionController::class, 'update']);
    // Train

    Route::post('/train', [TrainingController::class, 'store']);
    Route::post('/train/update/{id}', [TrainingController::class, 'update']);
    // approve

    Route::post('/add/approve', [ApprovedController::class, 'store']);
    Route::delete('/delete/approve/{id}', [ApprovedController::class, 'destroy']);
    // Gallary

    Route::post('/gallary', [GallaryController::class, 'store']);
    Route::post('/gallary/update/{id}', [GallaryController::class, 'update']);
    Route::delete('/gallary/delete/{id}', [GallaryController::class, 'destroy']);
    // WE

    Route::post('/work-experience', [WorkExperienceController::class, 'store']);
    Route::post('/work-experience/update/{id}', [WorkExperienceController::class, 'update']);
    Route::delete('/work-experience/delete/{id}', [WorkExperienceController::class, 'destroy']);
    // Contact

    Route::put('/update/contact/{id}', [ContactController::class, 'update']);
    Route::post('/add/contact', [ContactController::class, 'store']);
    Route::delete('/delete/contact/{id}', [ContactController::class, 'destroy']);
});

Route::middleware([CheckXToken::class])->group(function () {
    Route::get('/{locale}', [CompanyProfile::class, 'index']);
    Route::get('/about/{locale}', [AboutUsController::class, 'index']);

    Route::get('/inspect/{locale}', [InspectionController::class, 'index']);

    Route::get('/train/{locale}', [TrainingController::class, 'index']);

    Route::get('/get/approve', [ApprovedController::class, 'index']);

    Route::get('/gallary/{locale}', [GallaryController::class, 'index']);

    Route::get('/show/contact', [ContactController::class, 'index']);

    Route::post('/login', [UserController::class, 'login']);

});
