@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main>
        <div class="main-content">
            @yield('errors')
            <form method="post" id="edit-profile" enctype="multipart/form-data">
                @csrf
                <h1><input type="text" id="username" name="username" value="{{ $user->username }}" placeholder="Enter your username here" class="user-details-input"></h1>
                <span class="username-error">Username is already taken</span>
                <img class="member-pfp question-member-pfp" src="{{ asset($user->image) }}" alt="User's profile picture" />
                <label id="email-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ $user->email }}" placeholder="Enter your email here" class="user-details-input" class="user-details-input">
                <span class="email-error">Email is already taken</span>
                <label id="photo-label" for="photo">Profile Photo</label>
                <input id="photo" type="file" name="file" accept="image/png,image/jpg,image/jpeg">
                <input type="hidden" name="type" value="profile">
                <button id="edit-password" class="edit-password-button">Edit Password</button>
                <label class="edit-password" for="current-password">Current Password</label>
                <input class="edit-password" id="current-password" type="password" name="current-password" placeholder="Enter your current password here">
                <label class="edit-password" for="password">New Password</label>
                <input class="edit-password" id="password" type="password" name="password" placeholder="Enter your new password here" class="user-details-input">
                <span class="password-error">Password must be at least 8 characters long</span>
                <label class="edit-password" for="password_confirmation">Confirm Password</label>
                <input class="edit-password" id="password_confirmation" type="password" name="password_confirmation" placeholder="Retype your new password here">
                <span class="password-confirmation-error">Passwords do not match</span>
                <button formaction="../../users/{{ $user->id }}" id="submit">Save</button>
            </form>
        </div>
    </main>
@endsection
