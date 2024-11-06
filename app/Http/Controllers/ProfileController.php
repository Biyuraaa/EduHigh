<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(): View
    {
        return view('dashboard.profile.index');
    }
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        return view('dashboard.profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());
        try {
            if ($request->hasFile('image')) {
                if ($request->user()->image) {
                    Storage::delete('public/images/users/' . $request->user()->image);
                }
                $image = $request->file('image');
                $imageName = $user->name . '_' . time() . '.' . $image->getClientOriginalExtension();

                $image->storeAs('public/images/users/', $imageName);

                $user->image = $imageName;

                $user->save();
            }
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            return Redirect::route('profile.index')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return Redirect::route('profile.index')->with('status', 'profile-updated-failed');
        }
    }

    /**
     * Delete the user's account.
     */
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
