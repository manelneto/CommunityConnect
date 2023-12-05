<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\AnswerVote;

class AnswerVoteController extends Controller
{
    public function create(Request $request)
    {

        try {
            $request->validate([
                'id_answer' => 'required|integer',
                'id_user' => 'required|integer',
                'vote' => 'required|boolean',
            ]);

            $alreadyVoted = AnswerVote::where('id_answer', $request->id_answer)->where('id_user', $request->id_user)->exists();

            if ($alreadyVoted) {
                return response()->json([
                    'message' => 'You have already voted for this answer',
                ], 400);
            }

            $newvote = new AnswerVote();
            $newvote->id_answer = $request->id_answer;
            $newvote->id_user = $request->id_user;
            $newvote->likes = $request->vote;

            $newvote->save();

            $answer = Answer::withCount(['likes', 'dislikes'])->findOrFail($request->id_answer);

            return response()->json([
                'message' => 'Vote created successfully',
                'balance' => $answer->likes_count - $answer->dislikes_count,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Vote not created',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
