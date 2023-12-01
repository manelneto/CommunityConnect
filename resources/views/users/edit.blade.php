@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main>
        <div class="main-content">
            @yield('errors')
            <form method="post" id="edit-profile">
                @csrf
                <h1><input type="text" name="username" value="{{ $user->username }}"></h1>
                <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}" alt="User's profile picture" />
                <label id="email-label" for="email">Email: </label>
                <input id="email" type="email" name="email" value="{{ $user->email }}">
                <button id="edit-password" class="edit-password-button">Edit Password</button>
                <label class="edit-password" for="current-password">Current Password:</label>
                <input class="edit-password" id="current-password" type="password" name="current-password">
                <label class="edit-password" for="password">New Password:</label>
                <input class="edit-password" id="password" type="password" name="password">
                <label class="edit-password" for="password_confirmation">Confirm Password:</label>
                <input class="edit-password" id="password_confirmation" type="password" name="password_confirmation">
                <button formaction="../../users/{{ $user->id }}">Edit</button>
            </form>
        </div>
    </main>
@endsection
