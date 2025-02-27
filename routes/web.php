<?php

use App\Http\Controllers\VideosManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [VideosController::class, 'index'])->name('videos.index');
Route::get('/{id?}', [VideosController::class, 'show'])->name('videos.show');

// Ensure this route is defined
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('videos/manage')->group(function () {
        Route::get('/', [VideosManageController::class, 'index'])->name('videos.manage.index');
        Route::get('/{video}', [VideosManageController::class, 'show'])->name('videos.manage.show'); // Esta es la ruta que falta

        Route::get('/create', [VideosManageController::class, 'create'])->name('videos.manage.create');
        Route::post('/', [VideosManageController::class, 'store'])->name('videos.manage.store');

        Route::get('/{video}/edit', [VideosManageController::class, 'edit'])->name('videos.manage.edit');
        Route::post('/{video}', [VideosManageController::class, 'update'])->name('videos.manage.update');

        Route::delete('/{video}', [VideosManageController::class, 'destroy'])->name('videos.manage.destroy');
    });
});