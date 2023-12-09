<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFollowsTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller
{

    public function search(Request $request)
    {
        $tag = ($request->has('tag') && $request->get('tag') !== '') ? $request->get('tag') : '';
        $tags = Tag::where('name', 'ILIKE', '%' . $tag . '%')->get();
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $this->authorize('store', Tag::class);

        $tag = new Tag();
        $tag->name = $request->tag;
        $tag->save();

        return redirect('admin');
    }
   
    public function destroy(Request $request)
    {
        $tag = Tag::findOrFail($request->input('tag'));
        $this->authorize('destroy', Tag::class);
        try {
            $tag->delete();
            return redirect('admin');
        } catch (ModelNotFoundException $e) {
            return "Tag not found.";
        }
    }

    public function follow(Request $request)
    {
        $this->authorize('follow', Tag::class);

        $id = $request->get('id');
        try {
            $tag = Tag::findOrFail($id);
            $user = Auth::user()->id;
            UserFollowsTag::insert([
                'id_user' => $user,
                'id_tag' => $id
            ]);
            return response('Followed Tag');
        } catch (ModelNotFoundException $e) {
            return response('Tag not found');
        };
    }

    public function unfollow(Request $request)
    {
        $this->authorize('unfollow', Tag::class);

        $id = $request->get('id');
        try {
            $tag = Tag::findOrFail($id);
            $user = Auth::user()->id;
            UserFollowsTag::where([
                'id_user' => $user,
                'id_tag' => $id
            ])->delete();
            return response('Unfollowed Tag');
        } catch (ModelNotFoundException $e) {
            return response('Tag not found');
        };
    }
}
