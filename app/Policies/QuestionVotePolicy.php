<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionVotePolicy {

    use HandlesAuthorization;

    public function vote(User $user): bool
    {
        return Auth::check();
    }

    public function unvote(User $user): bool
    {
        return Auth::check();
    }

}
