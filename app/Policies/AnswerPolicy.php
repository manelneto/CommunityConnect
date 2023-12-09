<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy {

    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return Auth::check();
    }

    public function edit(User $user, Answer $answer): bool
    {
        $isModeratorOfCommunity = in_array(
            $answer->question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $isModeratorOfCommunity);
    }

    public function update(User $user, Answer $answer): bool
    {
        $isModeratorOfCommunity = in_array(
            $answer->question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $isModeratorOfCommunity);
    }

    public function destroy(User $user, Answer $answer): bool
    {
        $isModeratorOfCommunity = in_array(
            $answer->question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $isModeratorOfCommunity);
    }

    public function correct(User $user, Answer $answer): bool
    {
        $isModeratorOfCommunity = in_array(
            $answer->question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $isModeratorOfCommunity);
    }

    public function incorrect(User $user, Answer $answer): bool
    {
        $isModeratorOfCommunity = in_array(
            $answer->question->id_community,
            Auth::user()->moderatorCommunities->pluck('id')->toArray()
        );

        return ($user->id === Auth::user()->id) && (($answer->id_user === $user->id || Auth::user()->administrator) || $isModeratorOfCommunity);
    }
}
