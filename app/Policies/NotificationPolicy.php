<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class NotificationPolicy {

    use HandlesAuthorization;

    public function read(User $user, Notification $notification): bool
    {
        return ($user->id === Auth::user()->id) && ($notification->id_user === $user->id);
    }
}