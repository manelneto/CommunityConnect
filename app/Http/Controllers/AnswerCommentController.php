<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Events\CommentAnswerEvent;
use App\Models\AnswerComment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AnswerCommentController extends Controller {
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', AnswerComment::class);

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_answer' => 'required|integer',
        ]);

        $comment = new AnswerComment();
        $comment->content = $request['content'];
        $comment->id_answer = $request['id_answer'];
        $comment->id_user = Auth::user()->id;

        $comment->save();

        $answer = Answer::findOrFail($comment->id_answer);

        $question = Question::findOrFail($answer->id_question);

        event(new CommentAnswerEvent($question->id, $question->title, $answer->id_user));

        return redirect('questions/' . $question->id)->withSuccess('Comment posted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $comment = AnswerComment::findOrFail($id);
        $this->authorize('edit', $comment);

        try {
            return view('comment.edit', ['comment' => $comment]);
        }
        catch (ModelNotFoundException $e) {
            return "Comment not found.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $comment = AnswerComment::findOrFail($id);
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        try {
            $comment->content = $request->input('content');
            $comment->save();
            // $answer = Answer::findOrFail($comment->id_answer);
            return redirect('questions/' . $comment->answer->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Comment not found.";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $comment = AnswerComment::findOrFail($id);
        $this->authorize('destroy', $comment);

        try {
            $comment->delete();
            // $answer = Answer::findOrFail($comment->id_answer);
            return redirect('questions/' . $comment->answer->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Comment not found.";
        }
    }
}
