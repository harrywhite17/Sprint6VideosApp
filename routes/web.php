<?php

use App\Http\Controllers\UsersManageController;
use App\Http\Controllers\VideosManageController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\SeriesManageController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Set the root URL to the VideosController index method
Route::get('/', [VideosController::class, 'index'])->name('videos.index');

// Public video routes
Route::get('/viideos', [VideosController::class, 'index'])->name('videos.index');
Route::get('/viideos/{id}', [VideosController::class, 'show'])->name('videos.show');

// Video management routes (protected by middleware)
Route::middleware(['auth', 'verified', 'role:video-manager|super-admin'])->group(function () {
    Route::middleware(['auth', 'verified', 'role:video-manager|super-admin'])->prefix('videos/manage')->group(function () {
        Route::get('/', [VideosManageController::class, 'index'])->name('videos.manage.index');
        Route::get('/create', [VideosManageController::class, 'create'])->name('videos.manage.create');
        Route::post('/', [VideosManageController::class, 'store'])->name('videos.manage.store');
        Route::get('/{video}', [VideosManageController::class, 'show'])->name('videos.manage.show'); // Ensure this exists
        Route::get('/{video}/edit', [VideosManageController::class, 'edit'])->name('videos.manage.edit');
        Route::put('/{video}', [VideosManageController::class, 'update'])->name('videos.manage.update');
        Route::delete('/{video}', [VideosManageController::class, 'destroy'])->name('videos.manage.destroy');
    });
});

Route::get('/users', [UsersManageController::class, 'index'])->name('users.index');

// User management routes
Route::middleware(['auth', 'verified', 'role:user-manager|super-admin'])->group(function () {
    Route::prefix('users/manage')->group(function () {
        Route::get('/', [UsersManageController::class, 'index'])->name('users.manage.index');
        Route::get('/create', [UsersManageController::class, 'create'])->name('users.manage.create');
        Route::post('/', [UsersManageController::class, 'store'])->name('users.manage.store');
        Route::get('/{user}', [UsersManageController::class, 'show'])->name('users.manage.show');
        Route::get('/{user}/edit', [UsersManageController::class, 'edit'])->name('users.manage.edit');
        Route::put('/{user}', [UsersManageController::class, 'update'])->name('users.manage.update');
        Route::delete('/{user}', [UsersManageController::class, 'destroy'])->name('users.manage.destroy');
    });
});

// Series management routes (protected by middleware)
Route::middleware(['auth', 'verified', 'role:video-manager|super-admin'])->group(function () {
    Route::prefix('series/manage')->group(function () {
        Route::get('/', [SeriesManageController::class, 'index'])->name('series.manage.index');
        Route::get('/create', [SeriesManageController::class, 'create'])->name('series.create');
        Route::post('/', [SeriesManageController::class, 'store'])->name('series.manage.store');
        Route::get('/{series}/edit', [SeriesManageController::class, 'edit'])->name('series.edit');
        Route::put('/{series}', [SeriesManageController::class, 'update'])->name('series.update'); // Added route
        Route::delete('/{series}', [SeriesManageController::class, 'destroy'])->name('series.delete');
    });
});

// Public series routes
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{id}', [SeriesController::class, 'show'])->name('series.show');