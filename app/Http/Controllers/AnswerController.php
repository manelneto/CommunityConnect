<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Events\AnswerEvent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller {
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', Answer::class);

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_question' => 'required|integer',
            'file' => 'max:2048',
            'type' => 'in:answer'
        ]);

        $answer = new Answer();
        $answer->content = $request['content'];
        $answer->id_question = $request['id_question'];
        $answer->id_user = Auth::user()->id;

        $answer->save();

        $question = Question::findOrFail($answer->id_question);

        event(new AnswerEvent($answer->id_question, $question->title, $question->id_user));

        $fileController = new FileController();
        $fileController->upload($request, $answer->id);

        return redirect('questions/' . $answer->id_question)->withSuccess('Answer posted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $answer = Answer::findOrFail($id);
        $this->authorize('edit', $answer);
        try {
            return view('answer.edit', ['answer' => $answer]);
        }
        catch (ModelNotFoundException $e) {
            return "Answer not found.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $answer = Answer::findOrFail($id);
        $this->authorize('update', $answer);

        $request->validate([
            'content' => 'required|string|max:1000',
            'file' => 'max:2048',
            'type' => 'in:answer'
        ]);

        try {
            $answer->content = $request->input('content');
            $answer->save();

            $fileController = new FileController();
            $fileController->upload($request, $answer->id);

            return redirect('questions/' . $answer->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Answer not found.";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $answer = Answer::findOrFail($id);
        $this->authorize('destroy', $answer);
        try {
            $answer->delete();

            $fileController = new FileController();
            $fileController->delete('answer', $id);

            return redirect('questions/' . $answer->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Answer not found.";
        }
    }

    public function markCorrect(Request $request)
    {
        $id = $request->get('id');
        $answer = Answer::findOrFail($id);
        $question = Question::findOrFail($answer->id_question);

        $this->authorize('correct', $question);
        try {
            $answer->correct = true;
            $answer->save();
            return response('Answer marked as correct!');
        }
        catch (ModelNotFoundException $e) {
            return response("Answer not found.");
        }
    }

    public function markIncorrect(Request $request)
    {
        $id = $request->get('id');
        $answer = Answer::findOrFail($id);
        $this->authorize('correct', $answer);
        try {
            $answer->correct = false;
            $answer->save();
            return response('Delete answer mark!');
        }
        catch (ModelNotFoundException $e) {
            return response("Answer not found.");
        }
    }
}

