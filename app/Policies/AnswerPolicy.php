<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy {

    use HandlesAuthorization;

    public function show() {
        return true;
    }

    public function edit(User $user, Answer $answer)
    {
        return ($user->id == Auth::user()->id) && ($answer->id_user == $user->id || Auth::user()->administrator);
    }

    public function update(User $user, Answer $answer) {
        return ($user->id == Auth::user()->id) && ($answer->id_user == $user->id || Auth::user()->administrator);
    }

    public function destroy(User $user, Answer $answer) {
        return ($user->id == Auth::user()->id) && ($answer->id_user == $user->id || Auth::user()->administrator);
    }
}

