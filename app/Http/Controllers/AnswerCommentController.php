<?php

namespace App\Http\Controllers;

use App\Events\CommentAnswerEvent;
use App\Models\Answer;
use App\Models\AnswerComment;
use App\Models\Question;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerCommentController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('store', AnswerComment::class);

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_answer' => 'required|integer',
        ]);

        try {
            $comment = new AnswerComment();
            $comment->content = $request->input('content');
            $comment->id_answer = $request->input('id_answer');
            $comment->id_user = Auth::user()->id;

            $comment->save();

            $answer = Answer::findOrFail($comment->id_answer);
            $question = Question::findOrFail($answer->id_question);

            event(new CommentAnswerEvent($question->id, $question->title, $answer->id_user));
        } catch (Exception) {
            return redirect()->back()->withErrors('Comment could not be created');
        }

        return redirect()->back()->with('success', 'Comment successfully created');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        try {
            $comment = AnswerComment::findOrFail($id);
            $this->authorize('update', $comment);

            $comment->content = $request->input('content');
            $comment->last_edited = now();
            $comment->save();
        } catch (Exception) {
            return redirect()->back()->withErrors('Comment could not be edited');
        }

        return redirect()->back()->with('success', 'Comment successfully edited');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $comment = AnswerComment::findOrFail($id);
            $this->authorize('destroy', $comment);

            $comment->delete();
        } catch (Exception) {
            return redirect()->back()->withErrors('Comment could not be deleted');
        }

        return redirect()->back()->with('success', 'Comment successfully deleted');
    }
}
