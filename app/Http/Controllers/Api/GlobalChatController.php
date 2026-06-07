<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalMessage;
use Illuminate\Support\Facades\Auth;

class GlobalChatController extends Controller
{
    public function index()
    {
        return GlobalMessage::query()
            ->where('chat_id', null)
            ->with('user')
            ->orderBy('created_at')
            ->limit(50)
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:1000']
        ]);

        $message = GlobalMessage::create([
            'user_id' => $request->user()->id,
            'chat_id' => null,
            'body' => $request->body
        ]);

        return $message->load('user');
    }

    public function delete(int $id)
    {
        $message = GlobalMessage::findOrFail($id);

        if ($message->user_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();
    }
}
