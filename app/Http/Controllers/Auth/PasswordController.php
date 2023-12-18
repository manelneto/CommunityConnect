<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show(string $username, string $token) {
        if (Auth::check()) {
            return redirect('/communities');
        }
        return view('auth.password', ['username' => $username, 'token' => $token]);
    }

    public function update(Request $request) {
        $request->validate([
            'token' => 'required|string|min:40|max:40',
            'username' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $user = User::where('username', $request->input('username'))->first();

            if (!$user) {
                return redirect()->back()->withErrors('User not found');
            }

            if (!password_verify($request->input('token'), $user->password)) {
                return redirect()->back()->withErrors(['token' => 'Token is incorrect.']);
            }

            $user->password = Hash::make($request->input('password'));
            $user->save();

            $credentials = $request->only('username', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();

            return redirect()->route('communities')->with('success', 'You have successfully reset your password!');
        } catch (ModelNotFoundException $e) {
            return "User not found";
        }
    }
}
