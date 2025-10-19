<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(string $id)
    {
        $user = User::findOrFail($id);
        $id = Auth::id();

        $vehicles =  Vehicle::with([
            'company',
            'body',
            'gearbox',
            'color',
            'fuel',
            'model',
            'category',
            'condition',
            'image'
        ])
            ->when(Auth::check(), function ($query) use ($id) {
                $query->where("user_id", $id);
            })->orderBy('created_at', 'desc') // 👈 Ensures consistent ordering

            ->get();

        return view("profile.index", compact('user', 'vehicles'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
    
        $path = $request->file('image')->store('avatars', 'public');
        
        $request->user()->fill(
            $request->validated()
        );
        $request->user()->image=$path;
        $request->user()->save();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
    public function show(string $id){
          $user = User::findOrFail($id);
        $id = $user->id;

        $vehicles =  Vehicle::with([
            'company',
            'body',
            'gearbox',
            'color',
            'fuel',
            'model',
            'category',
            'condition',
            'image'
        ])
            ->where("user_id", $id)
            ->orderBy('created_at', 'desc') // 👈 Ensures consistent ordering

            ->get();

        return view("profile.show", compact('user', 'vehicles'));
    }
}
