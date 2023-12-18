<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Community;
use App\Models\Tag;

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

            $view->with('popularCommunities', $popularCommunities)
                ->with('popularTags', $popularTags);
        });
    }
}
