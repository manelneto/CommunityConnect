<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Community;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function search(Request $request, int $community = 0)
    {
        $after = $request->get('after', '2020-01-01');
        $before = $request->get('before', '2030-12-31');
        $sort = $request->get('sort') == 'recent' ? 'date' : 'likes_count';
        $searchTerm = $request->get('text', '');

        if ($community !== 0) {
            $questions = Question::with(['user', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before])
                ->where('id_community', $community);
        } else if ($request->get('community', 0) != 0) {
            $community = $request->get('community', '');
            $questions = Question::with(['user', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before])
                ->where('id_community', $community);
        } else {
            $questions = Question::with(['user', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->whereBetween('date', [$after, $before]);
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
                $formattedTerm = str_replace(' ', ' | ', $searchTerm);
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
        $questions = json_decode($this->search($request)->content());
        return view('questions.index', ['questions' => $questions]);
    }

    public function communityIndex(Request $request, int $community)
    {
        $questions = json_decode($this->search($request, $community)->content());
        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Question::class);
        $communities = Community::all();
        return view('questions.create', ['communities' => $communities]);
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
        ]);

        $question = new Question();
        $question->title = $request['title'];
        $question->content = $request['content'];
        $question->id_community = $request['id_community'];
        $question->id_user = Auth::user()->id;

        $question->save();

        return redirect()->route('questions')->withSuccess('Question posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            // Retrieve the question
            $question = Question::withCount(['likes', 'dislikes', 'tags'])
                ->findOrFail($id);

            // Retrieve answers related to the question
            $answers = Answer::with(['user', 'likes', 'dislikes'])
                ->withCount(['likes', 'dislikes'])
                ->where('id_question', $id)
                ->orderBy('date')
                ->get();

            // Pass the question and answers to the view
            return view('questions.show', [
                'question' => $question,
                'answers' => $answers
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
            return view('questions.edit', ['question' => $question]);
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
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000'
        ]);

        try {
            $question->title = $request->input(['title']);
            $question->content = $request->input(['content']);
            $question->save();
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
            $question->delete();
            return redirect('questions/');
        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }
}
