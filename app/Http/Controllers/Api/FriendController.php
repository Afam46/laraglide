<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $friends = Friend::with([
            'sender',
            'receiver'
        ])->where(function ($q) {

            $q->where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id());

        })->where('status', 'accepted')->get();

        return $friends->map(function ($friend) {

            return $friend->sender_id === Auth::id()
                ? $friend->receiver
                : $friend->sender;

        });
    }

    public function pendingIndex()
    {
        return Friend::with('sender')
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->get();
    }

    public function outgoingRequests()
    {
        return Friend::with('receiver')
            ->where('sender_id', Auth::id())
            ->where('status', 'pending')
            ->get();
    }

    public function request(int $id)
    {
        $exists = Friend::where(function ($q) use ($id) {

            $q->where('sender_id', Auth::id())
            ->where('receiver_id', $id);

        })
        ->orWhere(function ($q) use ($id) {

            $q->where('sender_id', $id)
            ->where('receiver_id', Auth::id());

        })
        ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Запрос уже существует'
            ], 422);
        }
        
        if ($id === Auth::id()) {
            return;
        }

        Friend::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'status' => 'pending'
        ]);
    }

    public function accept(Friend $friend)
    {
        $friend->update([
            'status' => 'accepted'
        ]);
    }

    public function delete(int $id)
    {
        $friend = Friend::findOrFail($id);

        $friend->delete();
    }
}
