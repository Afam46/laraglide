<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'birth_date' => 'nullable|date',
            'city' => 'nullable|string|max:255',
            'avatar' => 'nullable|string|max:255',
        ]);
        
        $user = Auth::user();
        $profile = $user->profile;
        
        $profile->update([
            'bio' => $request->bio,
            'birth_date' => $request->birth_date,
            'city' => $request->city,
            'avatar' => $request->avatar,
        ]);
    }
}