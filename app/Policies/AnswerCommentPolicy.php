<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AnswerComment;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerCommentPolicy {

    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return Auth::check();
    }

    public function edit(User $user, AnswerComment $comment): bool
    {
        return Auth::check() && ($user->id === Auth::user()->id) && ($comment->id_user === $user->id || Auth::user()->administrator);
    }

    public function update(User $user, AnswerComment $comment): bool
    {
        return Auth::check() && ($user->id === Auth::user()->id) && ($comment->id_user === $user->id || Auth::user()->administrator);
    }

    public function destroy(User $user, AnswerComment $comment): bool
    {
        return Auth::check() && ($user->id === Auth::user()->id) && ($comment->id_user === $user->id || Auth::user()->administrator);
    }
}
