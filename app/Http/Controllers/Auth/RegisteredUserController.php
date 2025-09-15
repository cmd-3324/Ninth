<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CarUser; // ← KEEP ONLY ONE
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255', 'unique:carsusers,UserName'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:carsusers,email'],
        'phone_number' => ['required', 'string', 'max:20'],
        'Location' => ['nullable', 'string', 'max:255'],
        'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $avatarPath = null;
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
    }

    $user = CarUser::create([
        'UserName' => $request->name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'Location' => $request->Location,
        'Avatar' => $avatarPath,
        'password' => Hash::make($request->password),
    ]);

    if ($user) {
        Auth::guard('web')->login($user);
        event(new Registered($user));
        
        // Use intended redirect with fallback
        return redirect()->intended(route('home', absolute: false));
    }

    return back()->with('error', 'Registration failed. Please try again.');
}
}