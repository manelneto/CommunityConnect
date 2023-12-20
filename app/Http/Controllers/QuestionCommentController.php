<?php

namespace App\Http\Controllers;

use App\Events\CommentQuestionEvent;
use App\Models\Question;
use App\Models\QuestionComment;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionCommentController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('store', QuestionComment::class);

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_question' => 'required|integer',
        ]);

        try {
            $comment = new QuestionComment();
            $comment->content = $request->input('content');
            $comment->id_question = $request->input('id_question');
            $comment->id_user = Auth::user()->id;

            $comment->save();

            $question = Question::findOrFail($comment->id_question);

            event(new CommentQuestionEvent($comment->id_question, $question->title, $question->id_user));
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
            $comment = QuestionComment::findOrFail($id);
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
            $comment = QuestionComment::findOrFail($id);
            $this->authorize('destroy', $comment);

            $comment->delete();
        } catch (Exception) {
            return redirect()->back()->withErrors('Comment could not be deleted');
        }

        return redirect()->back()->with('success', 'Comment successfully deleted');
    }
}
