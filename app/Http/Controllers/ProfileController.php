<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {

        $user = $request->user();

        if ($request->hasFile('profile_photo')) {
            $request->validate([
                'profile_photo' => 'image|max:10240',
            ]);

            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('status', 'Photo updated!');
    }
}