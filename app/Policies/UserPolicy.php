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
            && $user->administrator;
    }

    public function index(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
    }

    public function create(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
    }

    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
    }

    public function edit(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && ($target->id === $user->id || $user->administrator);
    }

    public function update(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && ($target->id === $user->id || $user->administrator);
    }

    public function block(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
    }

    public function unblock(User $user): bool
    {
        return $user->id === Auth::user()->id
            && $user->administrator;
    }

    public function destroy(User $user, User $target): bool
    {
        return $user->id === Auth::user()->id
            && ($target->id === $user->id || $user->administrator);
    }
}
