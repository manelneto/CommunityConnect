<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{

    use HandlesAuthorization;

    public function search(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous();
    }

    public function index(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous();
    }

    public function create(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous();
    }

    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous();
    }

    public function edit(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && !$user->anonymous()
            && !$target->anonymous()
            && ($target->id === $user->id || $user->administrator);
    }

    public function update(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && !$user->anonymous()
            && !$target->anonymous()
            && ($target->id === $user->id || $user->administrator);
    }

    public function destroy(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && !$user->anonymous()
            && !$target->anonymous()
            && ($target->id === $user->id || $user->administrator);
    }

    public function block(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous()
            && !$target->anonymous();
    }

    public function unblock(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator
            && !$user->anonymous()
            && !$target->anonymous();
    }
}
