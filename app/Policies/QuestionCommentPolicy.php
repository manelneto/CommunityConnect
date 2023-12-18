<?php

namespace App\Policies;

use App\Models\QuestionComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionCommentPolicy
{

    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function store(User $user): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked;
    }

    public function edit(User $user, QuestionComment $comment): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($comment->id_user === $user->id || $user->administrator || $user->moderates($comment->question->id_community));
    }

    public function update(User $user, QuestionComment $comment): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($comment->id_user === $user->id || $user->administrator || $user->moderates($comment->question->id_community));
    }

    public function destroy(User $user, QuestionComment $comment): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($comment->id_user === $user->id || $user->administrator || $user->moderates($comment->question->id_community));
    }
}
