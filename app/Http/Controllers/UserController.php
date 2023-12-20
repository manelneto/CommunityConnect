<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Notification;
use App\Models\Question;
use App\Models\Reputation;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $username = ($request->has('username') && $request->get('username') !== '') ? $request->get('username') : '';
        $users = User::with('communities')->where('username', 'ILIKE', '%' . $username . '%')->get();
        return response()->json($users);
    }

    /**
     * @throws AuthorizationException
     */
    public function admin(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('admin', User::class);
        $users = User::all();
        $tags = Tag::all();
        return view('pages.admin', ['users' => $users, 'tags' => $tags]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('store', User::class);

        $request->validate([
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $id = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => 'default.png'
        ])->id;

        return redirect('users/' . $id)->with('success', 'User successfully created');
    }

    public function show($id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
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
        } catch (Exception) {
            return redirect()->back()->withErrors('User not found');
        }
    }

    public function edit(int $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $user = User::findOrFail($id);
            $this->authorize('edit', $user);
            return view('users.edit', ['user' => $user]);
        } catch (Exception) {
            return redirect()->back()->withErrors('User cannot be edited');
        }
    }

    public function update(Request $request, int $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
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

            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->save();

            if (!password_verify($request->input('current-password'), $user->password) && $request->input('current-password') !== null) {
                return redirect()->back()->withErrors(['current-password' => 'Current password is incorrect']);
            }

            $user->password = $request->input('password') !== NULL ? Hash::make($request->input('password')) : $user->password;
            $user->save();
        } catch (Exception) {
            return redirect()->back()->withErrors('User could not be edited');
        }

        return redirect('users/' . $id)->with('success', 'User successfully edited');
    }

    public function destroy(int $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $user = User::findOrFail($id);
            $this->authorize('destroy', $user);

            $user->delete();

            $fileController = new FileController();
            $fileController->delete('profile', $id);
        } catch (Exception) {
            return redirect()->back()->withErrors('User could not be deleted');
        }

        if (Auth::user()->administrator && $id !== Auth::user()->id) {
            return redirect()->back()->with('success', 'User successfully deleted');
        } else {
            auth()->logout();
            return redirect('login')->with('success', 'User successfully deleted');
        }
    }

    public function block(Request $request): RedirectResponse
    {
        $request->validate([
            'user' => 'required|integer',
        ]);

        try {
            $user = User::findOrFail($request->input('user'));
            $this->authorize('block', $user);
            $user->blocked = true;
            $user->save();
        } catch (Exception) {
            return redirect()->back()->with('success', 'User could not be blocked');
        }

        return redirect()->back()->with('success', 'User successfully blocked');
    }

    public function unblock(Request $request): RedirectResponse
    {
        $request->validate([
            'user' => 'required|integer',
        ]);

        try {
            $user = User::findOrFail($request->input('user'));
            $this->authorize('unblock', $user);
            $user->blocked = false;
            $user->save();
        } catch (Exception) {
            return redirect()->back()->with('success', 'User could not be unblocked');
        }

        return redirect()->back()->with('success', 'User successfully unblocked');
    }
}
