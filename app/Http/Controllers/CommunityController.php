<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\UserFollowsCommunity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communities = Community::with(['users'])
            ->withCount(['users'])
            ->get();
        return view('pages.communities', ['communities' => $communities]);
    }

    public function follow(Request $request)
    {
        $id = $request->get('id');
        try {
            $community = Community::findOrFail($id);
            $user = Auth::user()->id;
            UserFollowsCommunity::insert([
                'id_user' => $user,
                'id_community' => $id
            ]);
            return response('Followed Community');
        } catch (ModelNotFoundException $e) {
            return response('Community not found');
        };
    }

    public function unfollow(Request $request)
    {
        $id = $request->get('id');
        try {
            $community = Community::findOrFail($id);
            $user = Auth::user()->id;
            UserFollowsCommunity::where([
                'id_user' => $user,
                'id_community' => $id
            ])->delete();
            return response('Unfollowed Community');
        } catch (ModelNotFoundException $e) {
            return response('Community not found');
        };
    }
}
