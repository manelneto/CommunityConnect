@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')

@section('content')

  @yield('header')

  <main class="sign-page-main">
    <div class="sign-page-main-content sign-page-main-content-login">
      <div class="sign-page-left-content">
        <h1 class="title-text">Sign In</h1>
        <h3 class="subtitle-text">Log In to Community Connect to ask <br> questions, answer people's questions, and
          <br>
          connect with others.
        </h3>
        <a class="go-to-sign-in" href="/register-page.php">Sign Up Here</a>
      </div>
      <form class="sign-page-right-content" action="" method="POST">
        <div class="form-group">
          <label for="username">Username or Email*</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="password">Password *</label>
          <input type="password" id="password" name="password" required>
        </div>
        <input type="checkbox" id="remember-me" name="remember-me">
        <label for="remember-me">Remember Me</label>
        <a href="#" class="forgot-password">Forgot Password?</a>
        <button type="submit">Sign In</button>
      </form>
    </div>
  </main>

  @yield('footer')

@endsection