<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy
{

    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous();
    }

    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous();
    }

    public function edit(User $user, Answer $answer): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous()
            && ($answer->id_user === $user->id || $user->administrator || $user->moderates($answer->question->id_community));
    }

    public function update(User $user, Answer $answer): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous()
            && ($answer->id_user === $user->id || $user->administrator || $user->moderates($answer->question->id_community));
    }

    public function destroy(User $user, Answer $answer): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous()
            && ($answer->id_user === $user->id || $user->administrator || $user->moderates($answer->question->id_community));
    }

    public function correct(User $user, Answer $answer): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous()
            && $answer->question->id_user === $user->id;
    }

    public function incorrect(User $user, Answer $answer): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous()
            && $answer->question->id_user === $user->id;
    }
}
