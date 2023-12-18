<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Reputation;
use App\Models\User;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $username = ($request->has('username') && $request->get('username') !== '') ? $request->get('username') : '';
        $users = User::with('communities')
            ->where('username', 'ILIKE', '%' . $username . '%')
            ->get();
        return response()->json($users);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', User::class);
        $users = User::all();
        $tags = Tag::all();
        return view('pages.admin', ['users' => $users, 'tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $users = User::all();
        return view('pages.admin', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', User::class);

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
        return view('pages.admin', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = User::with(['badges', 'moderatorCommunities'])->findOrFail($id);
            $questions = Question::with(['user', 'community', 'likes', 'dislikes'])->withCount(['answers', 'likes', 'dislikes'])->where('id_user', $id)->get();
            $answers = Answer::with(['user.communitiesRating', 'question', 'likes', 'dislikes'])->withCount(['likes', 'dislikes'])->where('id_user', $id)->get();
            $reputations = Reputation::with(['user', 'community'])->where('id_user', $id)->get();
            $notifications = Notification::with('user')->where('id_user', $id)->orderBy('date', 'desc')->get();
            $unread = Notification::with('user')->where('id_user', $id)->where('read', false)->get();
            $moderatorCommunities = $user->moderatorCommunities;
            return view('users.show', [
                'user' => $user,
                'questions' => $questions,
                'answers' => $answers,
                'reputations' => $reputations,
                'notifications' => $notifications,
                'unread' => $unread,
                'moderatorCommunities' => $moderatorCommunities
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors('User not found');
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
        } catch (ModelNotFoundException $e) {
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

        if ($request->input('username') !== $user->username) {
            $request->validate([
                'username' => 'required|string|max:20|unique:users'
            ]);
        }

        if ($request->input('email') !== $user->email) {
            $request->validate([
                'email' => 'required|email|max:250|unique:users'
            ]);
        }

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]);

            $fileController = new FileController();
            $fileController->upload($request, $id);
        }

        if ($request->input('password') !== null) {
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
        } catch (ModelNotFoundException $e) {
            return "User not found.";
        }
    }

    public function destroy(int $id) {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);

        try {
            $user->delete();

            $fileController = new FileController();
            $fileController->delete('profile', $id);

            if (Auth::user()->administrator && $id !== Auth::user()->id) {
                return redirect('users/' . $id);
            }
            else {
                auth()->logout();
                return redirect('login');
            }
        } catch (ModelNotFoundException $e) {
            return "User not found.";
        }
    }

    public function block(Request $request) {
        try {
            $user = User::findOrFail($request->input('user'));
            $this->authorize('block', $user);
            $user->blocked = true;
            $user->save();
            return redirect('admin');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors('User not found');
        }
    }

    public function unblock(Request $request) {
        try {
            $user = User::findOrFail($request->input('user'));
            $this->authorize('unblock', $user);
            $user->blocked = false;
            $user->save();
            return redirect('admin');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors('User not found');
        }
    }

    public function checkUsernameOrEmailExists(Request $request)
    {
        $username = $request->username_or_email;

        $user = User::where('username', $username)->exists();
        $email = User::where('email', $username)->exists();
    

        return response()->json(['user' => $user, 'email' => $email]);
    }
}
