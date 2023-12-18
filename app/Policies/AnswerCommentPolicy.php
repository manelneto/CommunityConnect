<?php

namespace App\Policies;

use App\Models\AnswerComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerCommentPolicy
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

    public function edit(User $user, AnswerComment $comment): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($comment->id_user === $user->id || $user->administrator || $user->moderates($comment->answer->question->id_community));
    }

    public function update(User $user, AnswerComment $comment): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($comment->id_user === $user->id || $user->administrator || $user->moderates($comment->answer->question->id_community));
    }

    public function destroy(User $user, AnswerComment $comment): bool
    {
        return $user->id === Auth::user()->id
            && !$user->blocked
            && ($comment->id_user === $user->id || $user->administrator || $user->moderates($comment->answer->question->id_community));
    }
}
