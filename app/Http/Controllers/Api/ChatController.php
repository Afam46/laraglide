<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
            return Auth::user()->chats()
                ->with([
                    'users',
                    'lastMessage.user'
                ])
                ->latest('updated_at')->get();
    }

    public function createOrGet(int $friendId)
    {
        $userId = Auth::id();

        $chat = Chat::whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereHas('users', function ($q) use ($friendId) {
            $q->where('user_id', $friendId);
        })
        ->first();

        if (!$chat) {

            $chat = Chat::create();

            $chat->users()->attach([
                $userId,
                $friendId
            ]);
        }

        return $chat;
    }

    public function messages(Chat $chat)
    {
        abort_unless(
            $chat->users()->where('user_id', Auth::id())->exists(),
            403
        );

        return $chat->messages()
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();
    }

    public function send(Request $request, Chat $chat)
    {
        abort_unless(
            $chat->users()->where('user_id', Auth::id())->exists(),
            403
        );

        $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);

        $chat->touch();

        return $message->load('user');
    }
}
