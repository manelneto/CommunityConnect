@extends('layouts.app')

@section('main')
    <main id="sign-page-main-content" class="registers">
        <article id="register-content">
            <h1 id="title-text">Join the Community</h1>
            <h3 id="subtitle-text">Sign Up to Community Connect to ask questions, answer people's questions, and connect with others. </h3>
            <a id="go-to-sign-in" href="/login">Have an account? Sign In</a>
        </article>
        <form id="register-page-form" action="{{ route('register') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="username">Username *</label>
                <input id="username"  type="text" name="username" required placeholder="Enter username here" class="user-details-input">
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input id="email" type="email" name="email" required placeholder="Enter email here" class="user-details-input">
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input id="password" type="password" name="password" required placeholder="Enter password here" class="user-details-input">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Retype password here" class="user-details-input">
            </div>
            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <input id="photo" type="file" name="file" accept="image/png,image/jpg,image/jpeg">
                <input type="hidden" name="type" value="profile">
            </div>
            <button type="submit" id="submit">Sign Up</button>
        </form>
    </main>
@endsection
