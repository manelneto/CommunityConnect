<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuestionComment;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionCommentPolicy {

    use HandlesAuthorization;

    public function store(User $user): bool
    {
        return Auth::check();
    }

    public function edit(User $user, QuestionComment $comment): bool
    {
        return Auth::check() && ($user->id === Auth::user()->id) && ($comment->id_user === $user->id || Auth::user()->administrator);
    }

    public function update(User $user, QuestionComment $comment): bool
    {
        return Auth::check() && ($user->id === Auth::user()->id) && ($comment->id_user === $user->id || Auth::user()->administrator);
    }

    public function destroy(User $user, QuestionComment $comment): bool
    {
        return Auth::check() && ($user->id === Auth::user()->id) && ($comment->id_user === $user->id || Auth::user()->administrator);
    }
}
