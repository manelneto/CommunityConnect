<?php

namespace App\Http\Controllers;

use App\Events\AnswerVoteEvent;
use App\Models\Answer;
use App\Models\AnswerVote;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerVoteController extends Controller {
    public function vote(Request $request)
    {
        $this->authorize('vote', AnswerVote::class)->withStatus(201);

        $id = $request->get('id');
        $vote = $request->get('vote');
        try {
            $answer = Answer::findOrFail($id);
            $user = Auth::user()->id;
            AnswerVote::insert([
                'id_user' => $user,
                'id_answer' => $id,
                'likes' => $vote,
            ]);

            $question = Question::findOrFail($answer->id_question);

            event(New AnswerVoteEvent($question->id, $question->title, $answer->id_user, $vote));

            return response('Vote added');
        } catch (Exception $e) {
            return response($e->getMessage(), 201);
        }
    }

    public function unvote(Request $request)
    {
        $this->authorize('unvote', AnswerVote::class);

        $id = $request->get('id');
        $vote = $request->get('vote');
        try {
            $answer = Answer::findOrFail($id);
            $user = Auth::user()->id;
            AnswerVote::where([
                'id_user' => $user,
                'id_answer' => $id,
                'likes' => $vote,
            ])->delete();
            return response('Vote removed');
        } catch (Exception $e) {
            return response($e->getMessage(), 201);
        }
    }
}
