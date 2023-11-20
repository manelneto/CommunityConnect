<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            'id_user' => 'required|integer'
        ]);

        $answer = new Answer();
        $answer->content = $request['content'];
        $answer->id_question = $request['id_question'];
        $answer->id_user = $request['id_user'];

        $answer->save();

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
            'content' => 'required|string|max:1000'
        ]);

        try {
            $answer->content = $request->input('content');
            $answer->save();
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
            return redirect('questions/' . $answer->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Answer not found.";
        }
    }
}
