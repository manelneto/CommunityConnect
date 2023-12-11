<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use App\Models\Question;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy {

    use HandlesAuthorization;

    private function isModeratorOfCommunity($answer): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return in_array(
            $answer->question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );
    }

    public function store(User $user): bool
    {
        return Auth::check();
    }

    public function edit(User $user, Answer $answer): bool
    {
        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $this->isModeratorOfCommunity($answer));
    }

    public function update(User $user, Answer $answer): bool
    {
        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $this->isModeratorOfCommunity($answer));
    }

    public function destroy(User $user, Answer $answer): bool
    {
        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $this->isModeratorOfCommunity($answer));

    }

    public function correct(User $user, Question $question)
    {
        return ($user->id === Auth::user()->id) && ($question->id_user === $user->id || Auth::user()->administrator || $this->isModeratorOfCommunity($question));
    }

    public function incorrect(User $user, Question $question): bool
    {
        return ($user->id === Auth::user()->id) && ($question->id_user === $user->id || Auth::user()->administrator || $this->isModeratorOfCommunity($question));
    }
}
