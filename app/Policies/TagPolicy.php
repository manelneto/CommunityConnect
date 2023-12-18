<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TagPolicy
{
    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
    }

    public function destroy(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
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
}
