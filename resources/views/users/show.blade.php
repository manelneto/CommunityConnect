@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@yield('header')

<main>
    <h1>{{ $user->username }}</h1>
    <h2>{{ $user->email }}</h2>
    <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
        alt="User's profile picture" />
    <ul>
        <li>About</li>
        <li>Questions</li>
        <li>Answers</li>
    </ul>
</main>

@yield('footer')