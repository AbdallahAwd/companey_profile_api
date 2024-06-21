<?php

use App\Http\Controllers\CompanyProfile;
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
