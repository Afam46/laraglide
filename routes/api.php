<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GlobalChatController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Middleware\UpdateLastSeen;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', UpdateLastSeen::class])->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/global-chat/messages', [GlobalChatController::class, 'index']);
    Route::post('/global-chat/messages', [GlobalChatController::class, 'store']);
    Route::delete('/global-chat/messages/{id}', [GlobalChatController::class, 'delete']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/online', [UserController::class, 'onlineIndex']);
    Route::get('/users/show/{id}', [UserController::class, 'show']);

    Route::post('/profiles/update', [ProfileController::class, 'update']);

    Route::get('/friends', [FriendController::class, 'index']);
    Route::get('/friends/pending', [FriendController::class, 'pendingIndex']);
    Route::get('/friends/outgoing', [FriendController::class, 'outgoingRequests']);
    Route::post('/friends/request/{id}', [FriendController::class, 'request']);
    Route::post('/friends/{friend}/accept', [FriendController::class, 'accept']);
    Route::delete('/friends/{id}', [FriendController::class, 'delete']);

    Route::get('/chats', [ChatController::class, 'index']);
    Route::get('/chats/{chat}/messages', [ChatController::class, 'messages']);
    Route::post('/chats/create/{friendId}', [ChatController::class, 'createOrGet']);
    Route::post('/chats/{chat}/send', [ChatController::class, 'send']);
});