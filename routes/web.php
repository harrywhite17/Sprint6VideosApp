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
Route::middleware(['auth', 'verified','role:video-manager|super-admin'])->group(function () {
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