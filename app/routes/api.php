<?php

// use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// need for the next api auth check
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UrlController::class)->names('api.users');
Route::apiResource('urls', UrlController::class)->names('api.urls');
