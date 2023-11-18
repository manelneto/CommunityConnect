<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy{

    use HandlesAuthorization;

    public function edit(User $user)
    {
        return $user->id == Auth::user()->id;
    }

    /*public function search() 
    {
        return Auth::check();
    }*/

    public function show() {
        return Auth::check();
    }

    public function update() {
        return Auth::check();
    }
}

