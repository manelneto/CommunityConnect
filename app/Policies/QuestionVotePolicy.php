<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionVotePolicy
{

    use HandlesAuthorization;

    public function vote(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function unvote(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

}
