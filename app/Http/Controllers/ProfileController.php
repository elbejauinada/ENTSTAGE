<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'birthday' => 'nullable|date',
            'major' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // Validate image file
        ]);
    
        $user = auth()->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->birthday = $request->input('birthday');
        $user->major = $request->input('major');
    
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($user->photo && \Storage::exists('public/' . $user->photo)) {
                \Storage::delete('public/' . $user->photo);
            }
    
            // Store the new photo
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }
    
        $user->save();
    
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }
    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
