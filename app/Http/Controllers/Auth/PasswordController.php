<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show(string $username, string $token): Factory|\Illuminate\Foundation\Application|View|Redirector|Application|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/communities');
        }
        return view('auth.password', ['username' => $username, 'token' => $token]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string|min:40|max:40',
            'username' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('username', $request->input('username'))->first();

        if (!$user) {
            return redirect()->back()->withErrors('User not found');
        }

        if (!password_verify($request->input('token'), $user->password)) {
            return redirect()->back()->withErrors('Incorrect token');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        return redirect()->route('communities')->with('success', 'You have successfully reset your password');
    }
}
