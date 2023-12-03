<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy {

    use HandlesAuthorization;

    public function search(User $user): bool
    {
        return Auth::user()->administrator;
    }

    public function index(User $user): bool
    {
        return Auth::user()->administrator;
    }

    public function create(User $user): bool
    {
        return Auth::user()->administrator;
    }

    public function store(User $user): bool
    {
        return Auth::user()->administrator;
    }

    public function edit(User $user): bool
    {
        return ($user->id === Auth::user()->id || Auth::user()->administrator);
    }

    public function update(User $user): bool
    {
        return ($user->id === Auth::user()->id || Auth::user()->administrator);
    }

    public function block_user(User $user): bool
    {
        return Auth::user()->administrator;
    }

    public function unblock_user(User $user): bool
    {
        return Auth::user()->administrator;
    }

    public function destroy(User $user): bool
    {
        return ($user->id === Auth::user()->id || Auth::user()->administrator);
    }
}
