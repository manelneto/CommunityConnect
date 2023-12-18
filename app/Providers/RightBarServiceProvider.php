<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Community;

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
            $popularCommunities = Community::withCount('users')
                    ->orderBy('users_count', 'desc')
                    ->take(4)
                    ->get();

            $view->with('popularCommunities', $popularCommunities);
        });
    }
}
