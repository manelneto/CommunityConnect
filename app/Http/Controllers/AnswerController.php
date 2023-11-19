<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $answer = Answer::findOrFail($id);
        $this->authorize('edit', $answer);
        try {
            return view('answer.edit', ['answer' => $asnwer]);
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
