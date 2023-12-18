<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TagPolicy
{
    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous();
    }

    public function destroy(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous();
    }

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
