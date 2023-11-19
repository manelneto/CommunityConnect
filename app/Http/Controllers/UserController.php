<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('index', User::class);
        $users = User::all();
        return view('users.admin', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($list_of_user_data)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => 'default.png'
        ]);

        $users = User::all();
        return view('users.admin', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $this->authorize('show', User::class);
        try {
            $user = User::findOrFail($id);
            $questions = Question::with(['user', 'community', 'likes', 'dislikes'])->where('id_user', $id)->get();
            $answers = Answer::with(['user', 'question', 'likes', 'dislikes'])->where('id_user', $id)->get();
            return view('users.show', [
                'user' => $user,
                'questions' => $questions,
                'answers' => $answers
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
        $user = User::findOrFail($id);
        $this->authorize('edit', $user);

        try {
            return view('users.edit', ['user' => $user]);
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
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        if ($request->input('username') !== $user->username){
            $request->validate([
                'username' => 'required|string|max:20|unique:users'
            ]);
        }
        if ($request->input('email') !== $user->email){
            $request->validate([
                'email' => 'required|email|max:250|unique:users'
            ]);
        }
        if ($request->input('password') !== null){
            $request->validate([
                'current-password' => 'required|min:8',
                'password' => 'required|min:8|confirmed'
            ]);
        }

        try {
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->save();
            if (!password_verify($request->input('current-password'), $user->password) && $request->input('current-password') !== null) {
                return redirect('users/' . $id . '/edit')->withErrors(['current-password' => 'Current password is incorrect.']);
            }
            $user->password = $request->input('password') !== NULL ? Hash::make($request->input('password')) : $user->password;
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
