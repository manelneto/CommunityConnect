<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Community;
use App\Models\Question;
use App\Models\Tag;
use App\Models\UserFollowsCommunity;
use App\Models\UserFollowsQuestion;
use App\Models\UserFollowsTag;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $questions = json_decode($this->search($request)->content());
        return view('questions.index', ['questions' => $questions]);
    }

    public function search(Request $request, int $community = 0, array $communities = []): JsonResponse
    {
        $after = $request->input('after', '2020-01-01');
        $before = $request->input('before', '2030-12-31');
        $sort = $request->input('sort') == 'recent' ? 'date' : 'likes_count';
        $searchTerm = $request->input('text', '');

        if ($community === 0 && count($communities) === 0 && (int)$request->input('community', 0) === 0 && (int)$request->input('communities', 0) === 0) {
            // all questions
            $questions = Question::with(['user.communitiesRating', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before]);
        } else if ($community > 0 || (int)$request->input('community', 0) > 0) {
            // community page
            $id_community = $community !== 0 ? $community : $request->input('community');
            $questions = Question::with(['user.communitiesRating', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before])
                ->where('id_community', $id_community);
        } else {
            // personal feed
            $communities = $communities !== [] ? $communities : explode(',', $request->get('communities', ''));
            $user = Auth::user()?->id;
            $userQuestions = UserFollowsQuestion::where('id_user', $user)->pluck('id_question')->toArray();
            $userTags = UserFollowsTag::where('id_user', $user)->pluck('id_tag')->toArray();

            $questions = Question::with(['user.communitiesRating', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers']);

            // questions from communities that user follows AND questions that user follows AND questions with tags that user follows
            $questions = $questions->where(function ($query) use ($communities, $userQuestions, $userTags, $after, $before) {
                $query->whereBetween('date', [$after, $before])->where(function ($query) use ($communities, $userQuestions, $userTags) {
                    $query
                        ->when(isset($communities[0]) && $communities[0] !== '', function ($query) use ($communities) {
                            $query->whereIn('id_community', $communities);
                        })
                        ->when(!empty($userQuestions), function ($query) use ($userQuestions) {
                            $query->orWhereIn('id', $userQuestions);
                        })
                        ->when(!empty($userTags), function ($query) use ($userTags) {
                            $query->orWhereHas('tags', function ($query) use ($userTags) {
                                $query->whereIn('id', $userTags);
                            });
                        });
                });
            });
        }

        if ($searchTerm != '') {
            if (preg_match('/^".+"$/', $searchTerm)) {
                // exact match search
                $searchTerm = trim($searchTerm, '"');
                $questions->where(function ($query) use ($searchTerm) {
                    $searchTermRegex = '\m' . preg_quote($searchTerm) . '\M';

                    $query->where('title', '~*', $searchTermRegex)->orWhere('content', '~*', $searchTermRegex);
                });
            } else if (preg_match('/^\[.+]$/', $searchTerm)) {
                // search by tag
                $tagName = trim($searchTerm, '[]');
                $questions->whereHas('tags', function ($query) use ($tagName) {
                    $query->where('name', $tagName);
                });
            } else {
                // full-text search
                $formattedTerm = addslashes(str_replace(' ', ' | ', $searchTerm));
                $questions->whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedTerm]);
            }
        }

        return response()->json($questions->orderBy($sort, 'desc')->paginate(10));
    }

    public function communityIndex(Request $request, int $community): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $questions = json_decode($this->search($request, $community)->content());
        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * @throws AuthorizationException
     */
    public function personalIndex(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('personalIndex', Question::class);

        $user = Auth::user()->id;
        $communities = UserFollowsCommunity::where('id_user', $user)->pluck('id_community')->toArray();
        $questions = json_decode($this->search($request, -1, $communities)->content());
        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('create', Question::class);
        $communities = Community::all();
        $tags = Tag::all();
        return view('questions.create', ['communities' => $communities, 'tags' => $tags]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
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
        $question->title = $request->input('title');
        $question->content = $request->input('content');
        $question->id_community = $request->input('id_community');
        $question->id_user = Auth::user()->id;

        $question->save();

        foreach ($request->all() as $key => $value) {
            if (preg_match('/^tags-\d+$/', $key)) {
                $question->tags()->attach($value);
            }
        }

        $fileController = new FileController();
        $fileController->upload($request, $question->id);

        return redirect('questions/' . $question->id)->with('success', 'Question successfully created');
    }

    public function show(int $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $question = Question::withCount(['answers', 'likes', 'dislikes', 'tags', 'comments'])->findOrFail($id);

            $answers = Answer::with(['user', 'likes', 'dislikes', 'comments'])
                ->withCount(['likes', 'dislikes'])
                ->where('id_question', $id)
                ->orderBy('likes_count', 'desc')
                ->get();

            $question->comments = $question->comments()->orderBy('date', 'desc')->get();

            foreach ($answers as $answer) {
                $answer->comments = $answer->comments()->orderBy('date', 'desc')->get();
            }

            return view('questions.show', [
                'question' => $question,
                'answers' => $answers,
            ]);
        } catch (Exception) {
            return redirect()->back()->withErrors('Question not found');
        }
    }

    public function edit(int $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $question = Question::with('tags')->withCount(['likes', 'dislikes'])->findOrFail($id);
            $this->authorize('edit', $question);
            $communities = Community::all();
            return view('questions.edit', ['question' => $question, 'communities' => $communities]);
        } catch (Exception) {
            return redirect()->back()->withErrors('Question cannot be edited');
        }
    }

    public function update(Request $request, int $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'id_community' => 'required|integer',
            'content' => 'required|string|max:1000',
            'file' => 'max:2048',
            'type' => 'in:question'
        ]);

        try {
            $question = Question::findOrFail($id);
            $this->authorize('update', $question);

            $question->title = $request->input('title');
            $question->id_community = $request->input('id_community');
            $question->content = $request->input('content');

            $fileController = new FileController();
            $fileController->upload($request, $question->id);

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
        } catch (Exception) {
            return redirect()->back()->withErrors('Answer could not be edited');
        }

        return redirect('questions/' . $id)->with('success', 'Question successfully edited');
    }

    public function destroy(int $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $question = Question::findOrFail($id);
            $this->authorize('destroy', $question);

            $fileController = new FileController();
            $fileController->delete('question', $id);

            $question->delete();
        } catch (Exception) {
            return redirect()->back()->withErrors('Question could not be deleted');
        }

        return redirect('questions/')->with('success', 'Question successfully deleted');
    }

    /**
     * @throws AuthorizationException
     */
    public function follow(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('follow', Question::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        try {
            $user = Auth::user()->id;
            UserFollowsQuestion::insert([
                'id_user' => $user,
                'id_question' => $id
            ]);
        } catch (Exception) {
            return response('Question could not be followed');
        }

        return response('Question successfully followed');
    }

    /**
     * @throws AuthorizationException
     */
    public function unfollow(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('unfollow', Question::class);

        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        try {
            $user = Auth::user()->id;
            UserFollowsQuestion::where([
                'id_user' => $user,
                'id_question' => $id
            ])->delete();
        } catch (Exception) {
            return response('Question could not be unfollowed');
        }

        return response('Question successfully unfollowed');
    }
}
