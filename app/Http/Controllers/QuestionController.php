<?php

namespace App\Http\Controllers;

use App\Models\AnswerComment;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Community;
use App\Models\QuestionComment;
use App\Models\UserFollowsCommunity;
use App\Models\UserFollowsQuestion;
use App\Models\UserFollowsTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function search(Request $request, int $community = 0, array $communities = [])
    {
        $after = $request->get('after', '2020-01-01');
        $before = $request->get('before', '2030-12-31');
        $sort = $request->get('sort') == 'recent' ? 'date' : 'likes_count';
        $searchTerm = $request->get('text', '');

        if ($community === 0 && count($communities) === 0 && (int) $request->get('community', 0) === 0 && (int) $request->get('communities', 0) === 0) {
            // all questions
            $questions = Question::with(['user.communitiesRating', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before]);
        } else if ($community !== 0 || (int) $request->get('community', 0) !== 0) {
            // community page
            $id_community = $community !== 0 ? $community : $request->get('community');
            $questions = Question::with(['user.communitiesRating', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before])
                ->where('id_community', $id_community);
        } else {
            // personal feed -> questions from communities that user follows AND questions that user follows AND questions from tags that user follows
            $communities = $communities !== [] ? $communities : explode(',', $request->get('communities'));
            $user = Auth::user()?->id;
            $userQuestions = UserFollowsQuestion::where('id_user', $user)->pluck('id_question')->toArray();
            $userTags = UserFollowsTag::where('id_user', $user)->pluck('id_tag')->toArray();
            $questions = Question::with(['user.communitiesRating', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->where(function ($query) use ($communities, $userQuestions, $after, $before) {
                    $query->whereBetween('date', [$after, $before])
                        ->whereIn('id_community', $communities)
                        ->orWhereIn('id', $userQuestions);
                })
                ->orWhereHas('tags', function ($query) use ($userTags) {
                    $query->whereIn('id', $userTags);
                });

        }

        if ($searchTerm != '') {
            if (preg_match('/^".+"$/', $searchTerm)) {
                // exact match search
                $searchTerm = trim($searchTerm, '"');
                $questions->where(function ($query) use ($searchTerm) {
                    $query->where('title', 'ILIKE', '%' . $searchTerm . '%')
                        ->orWhere('content', 'ILIKE', '%' . $searchTerm . '%');
                });
            } else if (preg_match('/^\[.+\]$/', $searchTerm)) {
                // search by tag
                $tagName = trim($searchTerm, '[]');
                $questions->whereHas('tags', function ($query) use ($tagName) {
                    $query->where('name', $tagName);
                });
            } else {
                // full-text-search
                $formattedTerm = addslashes(str_replace(' ', ' | ', $searchTerm));
                $questions->whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedTerm]);
            }
        }

        return response()->json($questions->orderBy($sort, 'desc')->paginate(10));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $questions = json_decode($this->search($request, 0, array())->content());
        return view('questions.index', ['questions' => $questions]);
    }

    public function communityIndex(Request $request, int $community)
    {
        $questions = json_decode($this->search($request, $community, array())->content());
        return view('questions.index', ['questions' => $questions]);
    }

    public function personalIndex(Request $request)
    {
        $this->authorize('personalIndex', Question::class);

        $user = Auth::user()->id;
        $communities = UserFollowsCommunity::where('id_user', $user)->pluck('id_community')->toArray();
        $questions = json_decode($this->search($request, 0, $communities)->content());
        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Question::class);
        $communities = Community::all();
        $tags = Tag::all();
        return view('questions.create', ['communities' => $communities, 'tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', Question::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'id_community' => 'required|integer',
            'file' => 'max:2048',
            'type' => 'in:question'
        ]);

        $question = new Question();
        $question->title = $request['title'];
        $question->content = $request['content'];
        $question->id_community = $request['id_community'];
        $question->id_user = Auth::user()->id;

        $question->save();

        foreach ($request->all() as $key => $value) {
            if (preg_match('/^tags-\d+$/', $key)) {
                $question->tags()->attach($value);
            }
        }

        $fileController = new FileController();
        $fileController->upload($request, $question->id);

        return redirect()->route('questions')->withSuccess('Question posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $question = Question::withCount(['answers', 'likes', 'dislikes', 'tags', 'comments'])
                ->findOrFail($id);

            $answers = Answer::with(['user', 'likes', 'dislikes', 'comments'])
                ->withCount(['likes', 'dislikes'])
                ->where('id_question', $id)
                ->orderBy('date')
                ->get();

            return view('questions.show', [
                'question' => $question,
                'answers' => $answers,
            ]);

        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            $question = Question::with('tags')->withCount(['likes', 'dislikes'])->findOrFail($id);
            $this->authorize('edit', $question);
            $communities = Community::all();
            return view('questions.edit', ['question' => $question, 'communities' => $communities]);
        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
    $question = Question::findOrFail($id);
    $this->authorize('update', $question);

    $request->validate([
        'content' => 'required|string|max:1000',
        'file' => 'max:2048',
        'type' => 'in:question'
    ]);

    try {
        $isModerator = in_array($question->id_community, Auth::user()?->moderatorCommunities->pluck('id')->toArray());
        $ownsQuestion = $question->user->id == Auth::user()->id;

        // Only non-moderators can update the title and id_community --------------TODO
        if (!$isModerator or ($isModerator and $ownsQuestion)) {
            $request->validate([
                'title' => 'required|string|max:255',
                'id_community' => 'required|integer'
            ]);

            $question->title = $request->input('title');
            $question->id_community = $request->input('id_community');
        }

        $question->content = $request->input('content');

        $fileController = new FileController();
        $fileController->upload($request, $question->id);

        $addTagName = $request->input('add-tag');

        $question->last_edited = now();
        
        $question->save();

        foreach ($question->tags as $tag) {
            $question->tags()->detach($tag->id);
        }

        foreach ($request->all() as $key => $value) {
            if (preg_match('/^tags-\d+$/', $key)) {
                $question->tags()->attach($value);
            }
        }

        return redirect('questions/' . $id);
    } catch (ModelNotFoundException $e) {
        return "Question not found.";
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('destroy', $question);
        try {
            $fileController = new FileController();
            $fileController->delete('question', $id);
            $question->delete();
            return redirect('questions/');
        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }

    public function follow(Request $request)
    {
        $this->authorize('follow', Question::class);

        $id = $request->get('id');
        try {
            $question = Question::findOrFail($id);
            $user = Auth::user()->id;
            UserFollowsQuestion::insert([
                'id_user' => $user,
                'id_question' => $id
            ]);
            return response('Followed Question');
        } catch (ModelNotFoundException $e) {
            return response('Question not found');
        }
        ;
    }

    public function unfollow(Request $request)
    {
        $this->authorize('unfollow', Question::class);

        $id = $request->get('id');
        try {
            $question = Question::findOrFail($id);
            $user = Auth::user()->id;
            UserFollowsQuestion::where([
                'id_user' => $user,
                'id_question' => $id
            ])->delete();
            return response('Unfollowed Question');
        } catch (ModelNotFoundException $e) {
            return response('Question not found');
        }
    }

    public function remove_tag(Request $request) 
    {
        $id_question = $request->get('questionId');
        $question = Question::findOrFail($id_question);
        $this->authorize('remove_tag', $question);

        $id_tag = $request->get('tagId');

        try {
            $tag = Tag::findOrFail($id_tag);
            $question->tags()->detach($tag->id);
            return response('Tag removed from question');
        } catch (ModelNotFoundException $e) {
            return response('Question not found');
        }
    }
}
