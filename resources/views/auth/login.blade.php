@extends('layouts.app')
@include ('layouts.errors')


@section('main')
    <main class="sign-page-main">
        <div class="sign-page-main-content sign-page-main-content-login">
            <div class="sign-page-left-content">
                <h1 class="title-text">Sign In</h1>
                <h3 class="subtitle-text">Log In to Community Connect to ask <br> questions, answer people's questions, and <br> connect with others.</h3>
                <a class="go-to-sign-in" href="/register">Don't have an account? Sign Up</a>
            </div>
            @yield('errors')
            <form class="sign-page-right-content" action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="username_or_email">Username or Email*</label>
                    <input type="text" id="username_or_email" name="username_or_email" required placeholder="Enter username or email here">
                </div>
                <div id="password-group" class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required placeholder="Enter password here">
                </div>
                <div id="remember-me-group">
                    <input type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me">Remember Me</label>
                </div>
                <a id="forgot-password" href="{{ route('login') }}">Forgot Password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
    </main>
@endsection
