<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionVote;

class QuestionVoteController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'id_question' => 'required|integer',
                'id_user' => 'required|integer',
                'vote' => 'required|boolean',
            ]);

            
            $alreadyVoted = QuestionVote::where('id_question', $request->id_question)
            ->where('id_user', $request->id_user)
            ->exists();
            
            if ($alreadyVoted) {
                return response()->json([
                    'message' => 'You have already voted for this question',
                ], 400);
            }
            $newvote = new QuestionVote();
            $newvote->id_question = $request->id_question;
            $newvote->id_user = $request->id_user;
            $newvote->likes = $request->vote;
            
            $newvote->save();

            $question = Question::withCount(['likes', 'dislikes'])->findOrFail($request->id_question);

            if ($question->id_user == $request->id_user){
                return response()->json([
                    'message' => 'User cannot vote on his own question',
                ], 400);
            }

            return response()->json([
                'message' => 'Vote created successfully',
                'likes' => $question->likes_count,
                'dislikes' => $question->dislikes_count,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Vote not created',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $request->validate([
                'id_question' => 'required|integer',
                'id_user' => 'required|integer',
            ]);

            $hasVoted = QuestionVote::where('id_question', $request->id_question)->where('id_user', $request->id_user)->first();

            if ($hasVoted){
                return response()->json([
                    'message' => 'Retrieved successfully',
                    'hasVoted' => true,
                    'vote' => $hasVoted->likes,
                ], 200);}
            else{
                return response()->json([
                    'message' => 'Retrieved successfully',
                    'hasVoted' => false,
                ], 200);
            }
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Not retrieved',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
