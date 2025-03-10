<?php

use App\Http\Controllers\UsersManageController;
use App\Http\Controllers\VideosManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Set the root URL to the UsersManageController index method
Route::get('/', [VideosController::class, 'index'])->name('videos.index');
// Add the /users route
Route::middleware(['auth'])->group(function () {
    Route::get('/uusers', [UsersManageController::class, 'index'])->name('users.index');
    Route::get('/uusers/{user}', [UsersManageController::class, 'show'])->name('users.show');
});

Route::get('/viideos', [VideosController::class, 'index'])->name('videos.index');
Route::get('/viideos/{id?}', [VideosController::class, 'show'])->name('videos.show');

Route::middleware(['auth', 'verified', 'role:video-manager|super-admin'])->group(function () {
    Route::prefix('videos/manage')->group(function () {
        Route::get('/', [VideosManageController::class, 'index'])->name('videos.manage.index');
        Route::get('/{video}', [VideosManageController::class, 'show'])->name('videos.manage.show');

        Route::get('/videos/manage/create', [VideosManageController::class, 'create'])->name('videos.manage.create');
        Route::post('/', [VideosManageController::class, 'store'])->name('videos.manage.store');

        Route::get('/{video}/edit', [VideosManageController::class, 'edit'])->name('videos.manage.edit');
        Route::put('/{video}', [VideosManageController::class, 'update'])->name('videos.manage.update');

        Route::get('/{video}/delete', [VideosManageController::class, 'delete'])->name('videos.manage.delete');
        Route::delete('/{video}', [VideosManageController::class, 'destroy'])->name('videos.manage.destroy');
    });
});

Route::middleware(['auth', 'verified', 'role:user-manager|super-admin'])->group(function () {
    Route::prefix('users/manage')->group(function () {
        Route::get('/', [UsersManageController::class, 'index'])->name('users.manage.index');
        Route::get('/create', [UsersManageController::class, 'create'])->name('users.manage.create');
        Route::post('/', [UsersManageController::class, 'store'])->name('users.manage.store');

        Route::get('/users/manage/{user}', [UsersManageController::class, 'show'])->name('users.manage.show');

        Route::get('/{user}/edit', [UsersManageController::class, 'edit'])->name('users.manage.edit');
        Route::put('/{user}', [UsersManageController::class, 'update'])->name('users.manage.update');

        Route::get('/{user}/delete', [UsersManageController::class, 'delete'])->name('users.manage.delete');
        Route::delete('/{user}', [UsersManageController::class, 'destroy'])->name('users.manage.destroy');
    });
});