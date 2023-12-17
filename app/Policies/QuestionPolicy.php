<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy
{

    use HandlesAuthorization;

    public function personalIndex(User $user): bool
    {
        return $user->id === Auth::user()->id;
    }

    public function create(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function edit(User $user, Question $question): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($question->id_user === $user->id || $user->administrator || $user->moderates($question->id_community));
    }

    public function update(User $user, Question $question): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($question->id_user === $user->id || $user->administrator || $user->moderates($question->id_community));
    }

    public function destroy(User $user, Question $question): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($question->id_user === $user->id || $user->administrator || $user->moderates($question->id_community));
    }

    public function follow(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function unfollow(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function remove_tag(User $user, Question $question): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($question->id_user === $user->id || $user->administrator || $user->moderates($question->id_community));
    }
}
