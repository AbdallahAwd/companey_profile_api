<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ApprovedController;
use App\Http\Controllers\CompanyProfile;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkExperienceController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', function (Request $request) {
        return User::all();
    });
});

Route::get('/{locale}', [CompanyProfile::class, 'index']);
Route::post('/update/company/{id}', [CompanyProfile::class, 'update']);
Route::post('/store/company', [CompanyProfile::class, 'store']);

Route::get('/about/{locale}', [AboutUsController::class, 'index']);
Route::post('/about', [AboutUsController::class, 'store']);
Route::post('/about/update/{id}', [AboutUsController::class, 'update']);

Route::get('/inspect/{locale}', [InspectionController::class, 'index']);
Route::post('/inspect', [InspectionController::class, 'store']);
Route::post('/inspect/update/{id}', [InspectionController::class, 'update']);

Route::get('/train/{locale}', [TrainingController::class, 'index']);
Route::post('/train', [TrainingController::class, 'store']);
Route::post('/train/update/{id}', [TrainingController::class, 'update']);

Route::get('/get/approve', [ApprovedController::class, 'index']);
Route::post('/add/approve', [ApprovedController::class, 'store']);
Route::delete('/delete/approve/{id}', [ApprovedController::class, 'destroy']);

Route::get('/gallary/{locale}', [GallaryController::class, 'index']);
Route::post('/gallary', [GallaryController::class, 'store']);
Route::post('/gallary/update/{id}', [GallaryController::class, 'update']);
Route::delete('/gallary/delete/{id}', [GallaryController::class, 'destroy']);

Route::post('/work-experience', [WorkExperienceController::class, 'store']);
Route::post('/work-experience/update/{id}', [WorkExperienceController::class, 'update']);
Route::delete('/work-experience/delete/{id}', [WorkExperienceController::class, 'destroy']);

Route::get('/show/contact', [ContactController::class, 'index']);
Route::put('/update/contact/{id}', [ContactController::class, 'update']);
Route::post('/add/contact', [ContactController::class, 'store']);
Route::delete('/delete/contact/{id}', [ContactController::class, 'destroy']);
