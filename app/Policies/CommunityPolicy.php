<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Community;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommunityPolicy {

    use HandlesAuthorization;

    public function follow(User $user): bool
    {
        return Auth::check();
    }

    public function unfollow(User $user): bool
    {
        return Auth::check();
    }
}
