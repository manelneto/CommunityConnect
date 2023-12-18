<?php

namespace App\Http\Controllers;

use App\Models\QuestionComment;
use App\Models\Question;
use App\Events\CommentQuestionEvent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class QuestionCommentController extends Controller {
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', QuestionComment::class);

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_question' => 'required|integer',
        ]);

        $comment = new QuestionComment();
        $comment->content = $request['content'];
        $comment->id_question = $request['id_question'];
        $comment->id_user = Auth::user()->id;

        $comment->save();

        $question = Question::findOrFail($comment->id_question);

        event(new CommentQuestionEvent($comment->id_question, $question->title, $question->id_user));

        return redirect('questions/' . $comment->id_question)->withSuccess('Comment posted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $comment = QuestionComment::findOrFail($id);
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
        $comment = QuestionComment::findOrFail($id);
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        try {
            $comment->content = $request->input('content');
            $comment->last_edited = now();
            $comment->save();
            return redirect('questions/' . $comment->id_question);
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
        $comment = QuestionComment::findOrFail($id);
        $this->authorize('destroy', $comment);

        try {
            $comment->delete();
            return redirect('questions/' . $comment->id_question);
        }
        catch (ModelNotFoundException $e) {
            return "Comment not found.";
        }
    }
}
