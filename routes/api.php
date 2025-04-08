<?php

use App\Http\Controllers\ApiMultimediaController;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        $user = auth()->user();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    $token = $user->createToken('authToken')->plainTextToken;
    return response()->json(['token' => $token], 201);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/multimedia', [ApiMultimediaController::class, 'index']);
    Route::get('/user/multimedia', [ApiMultimediaController::class, 'userMultimedia']);
    Route::post('/multimedia', [ApiMultimediaController::class, 'store']);
    Route::get('/multimedia/{id}', [ApiMultimediaController::class, 'show']);
    Route::delete('/multimedia/{id}', [ApiMultimediaController::class, 'destroy']);
});