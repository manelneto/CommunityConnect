<?php

namespace App\Http\Controllers;

use App\Events\QuestionVoteEvent;
use App\Models\Question;
use App\Models\QuestionVote;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class QuestionVoteController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function vote(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->authorize('vote', QuestionVote::class)->withStatus(201);

        $request->validate([
            'id' => 'required|integer',
            'vote' => 'required',
        ]);

        $id = $request->input('id');
        $vote = $request->input('vote');

        try {
            $question = Question::findOrFail($id);
            $user = Auth::user()->id;
            QuestionVote::insert([
                'id_user' => $user,
                'id_question' => $id,
                'likes' => $vote,
            ]);

            event(new QuestionVoteEvent($id, $question->title, $question->id_user, $vote));
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
        $this->authorize('unvote', QuestionVote::class)->withStatus(201);

        $request->validate([
            'id' => 'required|integer',
            'vote' => 'required',
        ]);

        $id = $request->input('id');
        $vote = $request->input('vote');

        try {
            $user = Auth::user()->id;
            QuestionVote::where([
                'id_user' => $user,
                'id_question' => $id,
                'likes' => $vote,
            ])->delete();
        } catch (Exception) {
            return response('Vote could not be removed', 201);
        }

        return response('Vote removed');
    }
}
