<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RedirectUrlController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/welcome/create-url', [WelcomeController::class, 'createUrl'])->name('welcome.create-url');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('urls', UrlController::class);

Route::get('/urls-search', [SearchUrlController::class, 'search'])
    ->middleware(['auth'])
    ->name('urls.search');

require __DIR__.'/auth.php';

Route::get('/{key}', [RedirectUrlController::class, 'redirect'])->name('redirect-url');
