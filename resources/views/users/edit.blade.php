@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@yield('header')

<form method="post">
    @csrf
    <h1><input type="text" name="username" value="{{ $user->username }}"></h1>
    <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
        alt="User's profile picture" />
    <ul>
        <li>About</li>
        <li>Questions</li>
        <li>Answers</li>
    </ul>
    <label for="email">Email: </label>
    <input id="email" type="email" name="email" value="{{ $user->email }}">
    <label for="password">Password: </label>
    <input id="password" type="password" name="password">
    <label for="confirm-password">Confirm Password: </label>
    <input id="confirm-password" type="password" name="confirm-password">
    <button formaction="../../users/{{ $user->id }}">Edit</button>
    <button formaction="../../users/{{ $user->id }}/delete">Delete</button>
</form>

@yield('footer')