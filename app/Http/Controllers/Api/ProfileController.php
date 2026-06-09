<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $profile = Auth::user()->profile;

        if (!$profile) {
            $profile = Profile::create([
                'user_id' => Auth::id()
            ]);
        }

        if ($request->hasFile('avatar')) {

            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $profile->avatar = '/storage/' . $request->file('avatar')->store('avatars', 'public');
        }

        $profile->bio = $request->bio;
        $profile->city = $request->city;
        $profile->birth_date = $request->birth_date;

        $profile->save();

        return response()->json([
            'message' => 'Профиль обновлен'
        ]);
    }
}