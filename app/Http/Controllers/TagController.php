<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFollowsTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller
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
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', Tag::class);

        $alreadyExists = Tag::where('name', $request->tag)->exists();

        if ($alreadyExists) {
            return redirect('admin')->with('error', 'Tag already exists.');
        }

        $tag = new Tag();
        $tag->name = $request->tag;
        $tag->save();

        return redirect('admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
    
    public function checkTagExists(Request $request)
    {
        $tag = Tag::where('name', $request->tag)->exists();
        return response()->json(['exists' => $tag]);
    }
}
