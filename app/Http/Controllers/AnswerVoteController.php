<?php

namespace App\Http\Controllers;

use App\Events\AnswerVoteEvent;
use App\Models\Answer;
use App\Models\AnswerVote;
use App\Models\Question;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AnswerVoteController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function vote(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('vote', AnswerVote::class)->withStatus(201);

        $request->validate([
            'id' => 'required|integer',
            'vote' => 'required',
        ]);

        $id = $request->input('id');
        $vote = $request->input('vote');

        try {
            $answer = Answer::findOrFail($id);
            $user = Auth::user()->id;
            AnswerVote::insert([
                'id_user' => $user,
                'id_answer' => $id,
                'likes' => $vote,
            ]);

            $question = Question::findOrFail($answer->id_question);

            event(new AnswerVoteEvent($question->id, $question->title, $answer->id_user, $vote));
        } catch (Exception) {
            return response('Vote could not be added', 201);
        }

        return response('Vote added');
    }

    /**
     * @throws AuthorizationException
     */
    public function unvote(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('unvote', AnswerVote::class)->withStatus(201);

        $request->validate([
            'id' => 'required|integer',
            'vote' => 'required',
        ]);

        $id = $request->input('id');
        $vote = $request->input('vote');

        try {
            $user = Auth::user()->id;
            AnswerVote::where([
                'id_user' => $user,
                'id_answer' => $id,
                'likes' => $vote,
            ])->delete();
        } catch (Exception) {
            return response('Vote could not be removed', 201);
        }

        return response('Vote removed');
    }
}
