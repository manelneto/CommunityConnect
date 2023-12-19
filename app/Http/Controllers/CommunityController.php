<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\UserFollowsCommunity;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $communities = Community::with(['users'])->withCount(['users'])->get();
        return view('pages.communities', ['communities' => $communities]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('store', Community::class);

        $request->validate([
            'name' => 'required|string|unique:community',
        ]);

        $community = new Community();
        $community->name = $request->input('name');
        $community->save();

        return redirect()->route('communities')->with('success', 'Community successfully created');
    }

    /**
     * @throws AuthorizationException
     */
    public function follow(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('follow', Community::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        try {
            $user = Auth::user()->id;
            UserFollowsCommunity::insert([
                'id_user' => $user,
                'id_community' => $id,
            ]);
        } catch (Exception) {
            return response('Community could not be followed');
        }

        return response('Community successfully followed');
    }

    /**
     * @throws AuthorizationException
     */
    public function unfollow(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('unfollow', Community::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        try {
            $user = Auth::user()->id;
            UserFollowsCommunity::where([
                'id_user' => $user,
                'id_community' => $id
            ])->delete();
        } catch (Exception) {
            return response('Community could not be unfollowed');
        }

        return response('Community successfully unfollowed');
    }
}
