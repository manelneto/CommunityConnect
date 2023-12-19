<?php

namespace App\Http\Controllers;

use App\Events\AnswerEvent;
use App\Models\Answer;
use App\Models\Question;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('store', Answer::class);

        $request->validate([
            'content' => 'required|string|max:1000',
            'id_question' => 'required|integer',
            'file' => 'max:2048',
            'type' => 'in:answer'
        ]);

        try {
            $answer = new Answer();
            $answer->content = $request->input('content');
            $answer->id_question = $request->input('id_question');
            $answer->id_user = Auth::user()->id;

            $answer->save();

            $fileController = new FileController();
            $fileController->upload($request, $answer->id);

            $question = Question::findOrFail($answer->id_question);
            event(new AnswerEvent($answer->id_question, $question->title, $question->id_user));
        } catch (Exception) {
            return redirect()->back()->withErrors('Answer could not be created');
        }

        return redirect()->back()->with('success', 'Answer successfully created');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'file' => 'max:2048',
            'type' => 'in:answer'
        ]);

        try {
            $answer = Answer::findOrFail($id);
            $this->authorize('update', $answer);

            $answer->content = $request->input('content');
            $answer->last_edited = now();
            $answer->save();

            $fileController = new FileController();
            $fileController->upload($request, $answer->id);
        } catch (Exception) {
            return redirect()->back()->withErrors('Answer could not be edited');
        }

        return redirect()->back()->with('success', 'Answer successfully edited');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $answer = Answer::findOrFail($id);
            $this->authorize('destroy', $answer);

            $fileController = new FileController();
            $fileController->delete('answer', $id);

            $answer->delete();
        } catch (Exception) {
            return redirect()->back()->withErrors('Answer could not be deleted');
        }

        return redirect()->back()->with('success', 'Answer successfully deleted');
    }

    public function markCorrect(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $id = $request->input('id');
            $answer = Answer::findOrFail($id);

            $this->authorize('correct', $answer);

            $answer->correct = true;
            $answer->save();
        } catch (Exception) {
            return response("Answer could not be marked as correct");
        }

        return response('Answer marked as correct');
    }

    public function markIncorrect(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        try {
            $id = $request->input('id');
            $answer = Answer::findOrFail($id);

            $this->authorize('incorrect', $answer);

            $answer->correct = false;
            $answer->save();
        } catch (Exception) {
            return response("Answer mark could not be deleted");
        }

        return response('Deleted answer mark');
    }
}
