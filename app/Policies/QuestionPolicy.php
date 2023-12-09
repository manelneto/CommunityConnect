<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy
{

    use HandlesAuthorization;

    public function personalIndex(User $user): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function store(User $user): bool
    {
        return Auth::check();
    }

    // Can edit / update question if:
    // 1 - Is question owner 
    // 2 - Is administrator
    // 3 - Moderates the community that the question belongs to

    public function edit(User $user, Question $question): bool
    {
        $isModeratorOfCommunity = in_array(
            $question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) &&
            ($question->id_user === $user->id || Auth::user()->administrator || $isModeratorOfCommunity);
    }


    public function update(User $user, Question $question): bool
    {
        $isModeratorOfCommunity = in_array(
            $question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) &&
            ($question->id_user === $user->id || Auth::user()->administrator || $isModeratorOfCommunity);
    }

    public function destroy(User $user, Question $question): bool
    {
        return ($user->id === Auth::user()->id) && ($question->id_user === $user->id || Auth::user()->administrator);
    }

    public function follow(User $user): bool
    {
        return Auth::check();
    }

    public function unfollow(User $user): bool
    {
        return Auth::check();
    }

    public function remove_tag(User $user, Question $question): bool
    {
        $isModeratorOfCommunity = in_array(
            $question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) &&
            ($question->id_user === $user->id || Auth::user()->administrator || $isModeratorOfCommunity);
    }
}
