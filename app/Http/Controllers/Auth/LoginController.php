<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show(): Factory|\Illuminate\Foundation\Application|View|Redirector|Application|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/communities');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username_or_email' => 'required',
            'password' => 'required',
        ]);

        $field = filter_var($credentials['username_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $credentials['username_or_email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/communities')->with('success', 'You have successfully logged in');
        }

        return back()->withErrors(['username_or_email' => 'The provided credentials do not match our records'])->onlyInput('username_or_email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('communities')->with('success', 'You have successfully logged out');
    }
}
