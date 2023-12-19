<?php

namespace App\Http\Controllers;

use App\Events\QuestionVoteEvent;
use App\Models\Question;
use App\Models\QuestionVote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionVoteController extends Controller {
    public function vote(Request $request)
    {
        $this->authorize('vote', QuestionVote::class)->withStatus(201);;

        $id = $request->get('id');
        $vote = $request->get('vote');
        try {
            $question = Question::findOrFail($id);
            $user = Auth::user()->id;
            QuestionVote::insert([
                'id_user' => $user,
                'id_question' => $id,
                'likes' => $vote,
            ]);

            event(New QuestionVoteEvent($id, $question->title, $question->id_user, $vote));

            return response('Vote added');
        } catch (Exception $e) {
            return response($e->getMessage(), 201);
        }
   }

    public function unvote(Request $request)
    {
        $this->authorize('unvote', QuestionVote::class);

        $id = $request->get('id');
        $vote = $request->get('vote');
        try {
            $question = Question::findOrFail($id);
            $user = Auth::user()->id;
            QuestionVote::where([
                'id_user' => $user,
                'id_question' => $id,
                'likes' => $vote,
            ])->delete();
            return response('Vote removed');
        } catch (Exception $e) {
            return response($e->getMessage(), 201);
        }
    }
}
