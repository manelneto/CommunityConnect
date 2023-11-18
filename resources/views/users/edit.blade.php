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
    <button id="edit-password">Edit Password</button>
    <label class="edit-password" for="current-password" hidden>Current Password:</label>
    <input class="edit-password" id="current-password" type="password" name="current-password" hidden>
    <label class="edit-password" for="new-password" hidden>New Password:</label>
    <input class="edit-password" id="new-password" type="password" name="new-password" hidden>
    <label class="edit-password" for="confirm-password" hidden>Confirm Password:</label>
    <input class="edit-password" id="confirm-password" type="password" name="confirm-password" hidden>
    <button formaction="../../users/{{ $user->id }}">Edit</button>
    <button formaction="../../users/{{ $user->id }}/delete">Delete</button>
</form>

@yield('footer')