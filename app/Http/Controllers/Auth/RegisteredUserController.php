<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dealer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name'=>['required','string','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => [
        'required',
        'string',
        'regex:/^(?:\+961|961|0)?(3|70|71|76|78|79|81|82|83|84|85|88|89)\d{6}$/',
        'unique:users,phone', // Adjust 'users' and 'phone' to your table and column
    ],
    'account_type'=>'required',


            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'last_name'=>$request->last_name,
            'phone'=>$request->phone,
            'email' => $request->email,
            'account_type'=>$request->account_type,
            'password' => Hash::make($request->password),
        ]);
        if($request->account_type==='dealer') {
            Dealer::create([
                'name'=>$user->name,
                'user_id'=>$user->id,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
