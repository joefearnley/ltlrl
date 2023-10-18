<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UrlController;

// need for the next api auth check
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->apiResources([
    'users' => UserController::class,
    'urls' => UrlController::class,
]);

// Unauthenticated way to create an url
