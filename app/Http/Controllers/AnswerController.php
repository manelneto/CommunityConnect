<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnswerController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try {
            return view('answer.edit', [
                'answer' => Answer::where('id', $id)->firstOrFail()
            ]);
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
        try {
            $answer = Answer::where('id', $id)->firstOrFail();
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
        try {
            $answer = Answer::where('id', $id)->firstOrFail();
            $answer->delete();
            return redirect('questions/' . $answer->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Answer not found.";
        }
    }

    public function postAnswer(Request $request){

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_question' => 'required|integer',
            'id_user' => 'required|integer'
        ]);

        $answer = new Answer();
        $answer->id_question = $request->id_question;
        $answer->id_user = $request->id_user;
        $answer->content = $request->content;

        $answer->save();
        
        return redirect('questions/' . $answer->id_question);
    }
}
