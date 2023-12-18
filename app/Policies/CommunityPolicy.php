<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommunityPolicy
{

    use HandlesAuthorization;

    public function follow(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous();
    }

    public function unfollow(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && !$user->anonymous();
    }
}
