@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="sign-page-main-content">
        <article id="sign-page-left-content">
            <h1 id="title-text">Reset your Password</h1>
            <h3 id="subtitle-text">Reset your Community Connect password to ask questions, answer people's questions, and connect with others.</h3>
        </article>
        @yield('errors')
        <form id="sign-page-right-content" action="{{ route('update-password') }}" method="post">
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
