<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
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
        //
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
        try {
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->save();
            if (!password_verify($request->input('current-password'), $user->password) || $request->input('new-password') !== $request->input('confirm-password')) {
                return redirect('users/' . $id);
            }
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
