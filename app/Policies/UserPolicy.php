<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy{

    use HandlesAuthorization;

    public function edit(User $user)
    {
        return ($user->id == Auth::user()->id || Auth::user()->administrator);
    }

    /*public function search() 
    {
        return Auth::check();
    }*/

    public function show() {
        return true;
    }

    public function update(User $user) {
        return ($user->id == Auth::user()->id || Auth::user()->administrator);
    }
}

