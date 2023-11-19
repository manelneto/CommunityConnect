<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function filterQuestions(Request $request) {
        $after = $request->get('after');
        $before = $request->get('before');

        $questions = Question::where('date', '>=', $after, 'and')->where('date', '<=', $before);

        $questions = $questions->with(['user', 'community', 'likes', 'dislikes', 'answers'])
            ->withCount(['likes', 'dislikes', 'answers'])
            ->orderBy('likes_count', 'desc')
            ->get();
        return response()->json($questions);
    }

    public function showMostLikedQuestions(Request $request)
    {
        if ($request->has('text') && $request->get('text') != '') {
            $searchTerm = $request->get('text');

            // check for exact match (enclosed in quotes)
            if (preg_match('/^".+"$/', $searchTerm)) {
                $searchTerm = trim($searchTerm, '"');

                $questions = Question::where('title', 'ILIKE', '%' . $searchTerm . '%')
                    ->orWhere('content', 'ILIKE', '%' . $searchTerm . '%');

            } else {
                // perform full text search
                $formattedTerm = str_replace(' ', ' | ', $searchTerm);

                $questions = Question::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedTerm]);
            }

            $questions = $questions->with(['user', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->orderBy('likes_count', 'desc')
                ->get();

        } else {

            $questions = Question::with(['user', 'community', 'likes', 'dislikes', 'answers'])
                ->withCount(['likes', 'dislikes', 'answers'])
                ->orderBy('likes_count', 'desc')
                ->get();
        }

        return view('pages.questions', ['questions' => $questions]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $this->authorize('show', Question::class);
        try {
            $answers = Answer::with(['user', 'likes', 'dislikes'])->where('id_question', $id)
                ->get();
            return view('questions.show', [
                'question' => Question::findOrFail($id),
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
        $question = Question::findOrFail($id);
        $this->authorize('edit', $question);
        try {
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
        try {
            $question->title = $request->input('title');
            $question->content = $request->input('content');
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

    public function postQuestion(Request $request){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'id_user' => 'required|integer',
            'id_community' => 'required|integer',
        ]);

        $question = new Question;
        $question->title = $validatedData['title'];
        $question->content = $validatedData['content'];
        $question->id_user = $validatedData['id_user'];
        $question->id_community = $validatedData['id_community'];

        $question->save();

        return redirect()->route('questions' )
        ->withSuccess('Question posted successfully!');
    }
}
