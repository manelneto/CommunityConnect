<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy {

    use HandlesAuthorization;

    public function personalIndex(User $user): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function store(User $user): bool
    {
        return Auth::check();
    }

    public function edit(User $user, Question $question): bool
    {
        return ($user->id === Auth::user()->id) && ($question->id_user === $user->id || Auth::user()->administrator);
    }

    public function update(User $user, Question $question): bool
    {
        return ($user->id === Auth::user()->id) && ($question->id_user === $user->id || Auth::user()->administrator);
    }

    public function destroy(User $user, Question $question): bool
    {
        return ($user->id === Auth::user()->id) && ($question->id_user === $user->id || Auth::user()->administrator);
    }

    public function follow(User $user): bool
    {
        return Auth::check();
    }

    public function unfollow(User $user): bool
    {
        return Auth::check();
    }
}
