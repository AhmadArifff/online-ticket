<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function registerForm(): View
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated(), $request->filled('remember'))) {
            $request->session()->regenerate();
            $this->toast('Login successful', 'success');
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Credentials do not match our records.',
        ]);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $name = $validated['name'] ?? trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? ''));

        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'customer',
        ]);

        Auth::login($user);

        $this->toast('Welcome! Registration successful', 'success');
        return redirect('/');
    }

    public function editProfile(): View
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        $this->toast('Profil Anda berhasil disimpan', 'success');

        return redirect()->route('profile.edit');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
