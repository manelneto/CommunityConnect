@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')

@section('content')

  @yield('header')  

  <main class="sign-page-main">
    <div class="sign-page-main-content">
      <div class="sign-page-left-content">
        <h1 class="title-text">Join the Community</h1>
        <h3 class="subtitle-text">Sign Up to Community Connect to ask <br> questions, answer people's questions, and
          <br>
          connect with others.
        </h3>
        <a class="go-to-sign-in" href="/login-page.php">Have an Account? Sign In</a>
      </div>
      <form class="sign-page-right-content" action="" method="POST">
        @csrf
        <div class="form-group">
          <label for="username">Username *</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password *</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="confirm-password">Confirm password *</label>
          <input type="password" id="confirm-password" name="confirm_password" required>
        </div>
        <small>Password must contain bla bla bla bla bla</small>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </main>
  
  @yield('footer')

@endsection
