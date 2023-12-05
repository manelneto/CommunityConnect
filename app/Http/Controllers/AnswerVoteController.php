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

            $answer = Answer::findOrFail($request->id_answer);
            if ($answer->id_user == $request->id_user){
                return response()->json([
                    'message' => 'User cannot vote on his own answer',
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

    public function index(Request $request){
        try {
            $request->validate([
                'id_answer' => 'required|integer',
                'id_user' => 'required|integer',
            ]);

            $vote = AnswerVote::where('id_answer', $request->id_answer)->where('id_user', $request->id_user)->first();

            if ($vote){
                return response()->json([
                    'message' => 'Vote found',
                    'hasVoted' => true,
                    'vote' => $vote->likes,
                ], 200);
            }
            else{
                return response()->json([
                    'message' => 'Vote not found',
                    'hasVoted' => false,
                ], 200);
            }
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Vote not found',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
