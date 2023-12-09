@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main class="sign-page-main-content">
        <article class="sign-page-left-content">
            <h1 class="title-text">Reset your password</h1>
            <h3 class="subtitle-text">Reset your Community Connect password to ask <br> questions, answer people's questions, and <br> connect with others.</h3>
        </article>
        @yield('errors')
        <form class="sign-page-right-content" action="{{ route('update-password') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="username" value="{{ $username }}">
            <div class="form-group">
                <label for="password">New Password *</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <small>Password must contain at least 8 characters</small>
            <button type="submit">Reset Password</button>
        </form>
    </main>
@endsection
