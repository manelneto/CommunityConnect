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

    public function showMostLikedQuestions(Request $request)
    {
        // exact search
        if ($request->has('text')) {
            $searchTerm = $request->get('text');

            $questions = Question::where('title', 'ILIKE', '%' . $searchTerm . '%')
                ->orWhere('content', 'ILIKE', '%' . $searchTerm . '%')
                ->with(['user', 'community', 'likes', 'dislikes', 'answers'])
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
        try {

            $answers = Answer::with(['user', 'likes', 'dislikes'])->where('id_question', $id)
                ->get();
            return view('questions.show', [
                'question' => Question::where('id', $id)->firstOrFail(),
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
            return view('questions.edit', [
                'question' => Question::where('id', $id)->firstOrFail()
            ]);
        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $question = Question::where('id', $id)->firstOrFail();
            $question->title = $request->input('title');
            $question->content = $request->input('content');
            $question->save();
            return redirect('questions/' . $question->id);
        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $question = Question::where('id', $id)->firstOrFail();
            $question->delete();
            return redirect('questions/');
        } catch (ModelNotFoundException $e) {
            return "Question not found.";
        }
    }
}
