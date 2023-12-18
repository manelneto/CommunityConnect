<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
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
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->id;

        $fileController = new FileController();
        $fileController->upload($request, $id);

        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        return redirect()->route('communities')->withSuccess('You have successfully registered & logged in!');
    }
}
