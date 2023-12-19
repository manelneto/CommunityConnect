<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\UserFollowsTag;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    public function search(Request $request): JsonResponse
    {
        $tag = ($request->has('tag') && $request->input('tag') !== '') ? $request->get('tag') : '';
        $tags = Tag::where('name', 'ILIKE', '%' . $tag . '%')->get();
        return response()->json($tags);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('store', Tag::class);

        $request->validate([
            'name' => 'required|string|unique:tag',
        ]);

        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->save();

        return redirect()->back()->with('success', 'Tag successfully created');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request): RedirectResponse
    {
        $this->authorize('update', Tag::class);

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|unique:tag',
        ]);

        try {
            $tag = Tag::findOrFail($request->input('id'));
            $tag->name = $request->input('name');
            $tag->save();
        } catch (Exception) {
            return redirect()->back()->withErrors('Tag not found');
        }

        return redirect()->back()->with('success', 'Tag successfully edited');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->authorize('destroy', Tag::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $tag = Tag::findOrFail($request->input('id'));
            $tag->delete();
        } catch (Exception) {
            return redirect()->back()->withErrors('Tag not found');
        }

        return redirect()->back()->with('success', 'Tag successfully deleted');
    }

    /**
     * @throws AuthorizationException
     */
    public function follow(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('follow', Tag::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        try {
            $user = Auth::user()->id;
            UserFollowsTag::insert([
                'id_user' => $user,
                'id_tag' => $id,
            ]);
        } catch (Exception) {
            return response('Tag could not be followed');
        }

        return response('Tag successfully followed');
    }

    /**
     * @throws AuthorizationException
     */
    public function unfollow(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('unfollow', Tag::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        try {
            $user = Auth::user()->id;
            UserFollowsTag::where([
                'id_user' => $user,
                'id_tag' => $id
            ])->delete();
        } catch (Exception) {
            return response('Tag  could not be unfollowed');
        }

        return response('Tag successfully unfollowed');

    }
}
