<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

use App\Models\Vehicle;
  use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(string $id)
    {
      

$totalLikes = DB::table('likes')
    ->join('ads', 'likes.ad_id', '=', 'ads.id')
    ->where('ads.user_id', $id)
    ->count();
        $user = User::with('subscription')
        ->where('id',$id)
        ->first();
       
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
            'images',
            'ad',
            'ad.likes',
            'user'
        ])
            ->when(Auth::check(), function ($query) use ($id) {
                $query->where("user_id", $id);
            })->orderBy('created_at', 'desc') // 👈 Ensures consistent ordering

            ->get();

        return view("profile.index", compact('user', 'vehicles','totalLikes'));
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
       
        $image=$request->file('image');
        if($image){
                $path = $image->store('avatars', 'public');
        } else{
               $path=$request->input('hiddenImage');

        }
      
    
        
        $request->user()->fill(
            $request->validated()
        );
        $request->user()->image=$path;
        $request->user()->save();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
      

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile updated');
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
        $totalLikes = DB::table('likes')
    ->join('ads', 'likes.ad_id', '=', 'ads.id')
    ->where('ads.user_id', $id)
    ->count();
          $user = User::findOrFail($id);
           if(Auth::id()==$user->id) {
            return redirect()->route('profile.index',Auth::id());
        }
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
            'images',
            'ad',
            'ad.likes',
            'user'
        ])
            ->where("user_id", $id)
            ->orderBy('created_at', 'desc') // 👈 Ensures consistent ordering
            ->paginate(10);

        return view("profile.show", compact('user', 'vehicles','totalLikes'));
    }
    public function deleteAvatar(Request $request) {
        $user=User::findOrFail(Auth::id());
        $user->image='public/images/avatar.png';
        $user->save();
        return redirect()->back();
    }
}
