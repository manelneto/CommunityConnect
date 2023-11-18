<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            return view('users.show', [
                'user' => User::where('id', $id)->firstOrFail()
            ]);
        }
        catch (ModelNotFoundException $e) {
            return "User not found.";
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            return view('users.edit', [
                'user' => User::where('id', $id)->firstOrFail()
            ]);
        }
        catch (ModelNotFoundException $e) {
            return "User not found.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $user = User::where('id', $id)->firstOrFail();
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->save();
            return redirect('users/' . $id);
        }
        catch (ModelNotFoundException $e) {
            return "User not found.";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
