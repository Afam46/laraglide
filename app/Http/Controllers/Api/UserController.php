<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Friend;

class UserController extends Controller
{
    public function index()
    {
        $excludedIds = Friend::where(function ($q) {

            $q->where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id());

        })->get()->flatMap(function ($friend) {

            return [
                $friend->sender_id,
                $friend->receiver_id
            ];

        })->unique();

        return User::whereNotIn('id', $excludedIds)->where('id', '!=', Auth::id())->get();
    }
}
