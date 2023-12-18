<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Community;
use App\Models\Tag;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;

class RightBarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.aside', function ($view) {
            // communities with the most followers
            $popularCommunities = Community::withCount('users')
                    ->orderBy('users_count', 'desc')
                    ->take(5)
                    ->get();

            // tags that appear in the most questions
            $popularTags = Tag::withCount('questionTags as questions_count')
            ->orderByDesc('questions_count')
            ->take(5)
            ->get();

            $totalQuestions = Question::count();
            $totalAnswers = Answer::count();
            $totalUsers = User::count();

            $totalSolvedQuestions = Question::whereHas('answers', function ($query) {
                $query->where('correct', true);
            })->count();

            $view->with('popularCommunities', $popularCommunities)
                ->with('popularTags', $popularTags)
                ->with('totalQuestions', $totalQuestions)
                ->with('totalAnswers', $totalAnswers)
                ->with('totalUsers', $totalUsers)
                ->with('totalSolvedQuestions', $totalSolvedQuestions);
        });
    }
}
