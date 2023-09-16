<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Lomkit\Rest\Facades\Rest;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Rest::resource('users', \App\Http\Controllers\UsersController::class);
Rest::resource('urls', \App\Rest\Resources\UrlController::class);
