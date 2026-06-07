<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
USE App\Http\Controllers\Api\GlobalChatController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/global-chat/messages', [GlobalChatController::class, 'index']);
    Route::post('/global-chat/messages', [GlobalChatController::class, 'store']);
    Route::delete('/global-chat/messages/{id}', [GlobalChatController::class, 'delete']);
});