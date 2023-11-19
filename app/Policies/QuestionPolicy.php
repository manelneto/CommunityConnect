<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy {

    use HandlesAuthorization;

    public function show() {
        return true;
    }

    public function edit(User $user, Question $question)
    {
        return ($user->id == Auth::user()->id) && ($question->id_user == $user->id || Auth::user()->administrator);
    }

    public function update(User $user, Question $question) {
        return ($user->id == Auth::user()->id) && ($question->id_user == $user->id || Auth::user()->administrator);
    }

    public function destroy(User $user, Question $question) {
        return ($user->id == Auth::user()->id) && ($question->id_user == $user->id || Auth::user()->administrator);
    }
}

