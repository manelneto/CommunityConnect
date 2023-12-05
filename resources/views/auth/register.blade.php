@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main class="sign-page-main-content">
        <article class="sign-page-left-content">
            <h1 class="title-text">Join the Community</h1>
            <h3 class="subtitle-text">Sign Up to Community Connect to ask <br> questions, answer people's questions, and <br> connect with others. </h3>
            <a class="go-to-sign-in" href="/login">Have an Account? Sign In</a>
        </article>
        @yield('errors')
        <form class="sign-page-right-content" action="{{ route('register') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="username">Username *</label>
                <input id="username"  type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input id="email" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <small>Password must contain at least 8 characters</small>
            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <input id="photo" type="file" name="file" accept="image/png,image/jpg,image/jpeg">
                <input type="hidden" name="type" value="profile">
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </main>
@endsection
