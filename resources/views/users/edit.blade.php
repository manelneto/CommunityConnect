@extends('layouts.app')

@section('main')
    <main>
        <section class="add-tooltip-edit-profile">
            <h1 id="edit-profile-title">Edit Profile</h1>
            <div class="tooltip-icon" id="user-edit-profile">
                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                    <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                </svg>
                <p class="tooltip-text">
                    You can edit any of your personal details here.
                    To edit your email or username, just click on the field where they appear and change them.
                    To edit your password, click on the <b>Edit Password</b> button and fill in the fields that appear.
                    You can also edit your profile picture by clicking on it and selecting a new one.
                    When you're done, click on the <b>Save</b> button.
                </p>
            </div>
        </section>
        <form method="post" id="edit-profile" enctype="multipart/form-data">
            @csrf
            <h1><input type="text" id="username" name="username" value="{{ $user->username }}" placeholder="Enter your username here" class="user-details-input"></h1>
            <img class="member-pfp question-member-pfp" src="{{ asset($user->image) }}" alt="User's profile picture" />
            <label id="email-label" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ $user->email }}" placeholder="Enter your email here" class="user-details-input">
            <label id="photo-label" for="photo">Profile Photo</label>
            <input id="photo" type="file" name="file" accept="image/png,image/jpg,image/jpeg">
            <input type="hidden" name="type" value="profile">
            @if (Auth::user()?->id === $user->id)
                <button id="edit-password" class="edit-password-button">Edit Password</button>
                <label class="edit-password" for="current-password">Current Password</label>
                <input class="edit-password" id="current-password" type="password" name="current-password" placeholder="Enter your current password here">
                <label class="edit-password" for="password">New Password</label>
                <input class="edit-password user-details-input" id="password" type="password" name="password" placeholder="Enter your new password here">
                <label class="edit-password" for="password_confirmation">Confirm Password</label>
                <input class="edit-password user-details-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Retype your new password here">
            @endif
            <button formaction="../../users/{{ $user->id }}" id="submit">Save</button>
        </form>
    </main>
@endsection
