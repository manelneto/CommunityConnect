@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@yield('header')

<main>
    <span id="edit-profile-a">
    <h1>{{ $user->username }}</h1>
    @if(Auth::user()->id === $user->id || Auth::user()->administrator)
            <a class="edit-profile" href="{{ route('edit-user', $user->id) }}">Edit</a>
    @endif
    </span>
    <h2>{{ $user->email }}</h2>
    <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
        alt="User's profile picture" />
        <ul>
            <li>About</li>
            <li id="questions-button">Questions</li>
            <li id="answers-button">Answers</li>
        </ul>
    <section id="my-questions" hidden>
        @foreach ($questions as $question)
            @include('partials.question', ['question' => $question])
        @endforeach
    </section>
    <section id="my-answers" hidden>
        @foreach ($answers as $answer)
            @include('partials.answer', ['answer' => $answer])
        @endforeach
    </section>
</main>

@yield('footer')