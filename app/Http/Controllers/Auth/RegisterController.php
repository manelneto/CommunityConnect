<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class RegisterController extends Controller
{
    public function show(): Factory|\Illuminate\Foundation\Application|View|Redirector|Application|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/communities');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'file' => 'image|mimes:png,jpg,jpeg|max:2048',
            'type' => 'in:profile'
        ]);

        if (preg_match('/^anonymous.*$/', $request->username)) {
            return redirect()->back()->withErrors('Username must not start with "anonymous"');
        }

        $id = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ])->id;

        $fileController = new FileController();
        $fileController->upload($request, $id);

        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        return redirect()->route('communities')->with('success', 'You have successfully registered & logged in');
    }
}
