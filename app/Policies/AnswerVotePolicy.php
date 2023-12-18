<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerVotePolicy
{

    use HandlesAuthorization;

    public function vote(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous();
    }

    public function unvote(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous();
    }
}
