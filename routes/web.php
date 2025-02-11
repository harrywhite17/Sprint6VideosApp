<?php

use App\Http\Controllers\VideosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome'], 200);
});

Route::get('/videos/{id?}', [VideosController::class, 'show'])->name('videos.show');

// Ensure this route is defined
Route::middleware(['auth'])->group(function () {
    Route::get('/videos/manage', [VideosController::class, 'manage'])->name('videos.manage');
});