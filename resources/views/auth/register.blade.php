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
        <a class="go-to-sign-in" href="/login">Have an Account? Sign In</a>
      </div>
      @if ($errors->any())
        <div class="error-box">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form class="sign-page-right-content" action="{{ route('register') }}" method="POST">
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
          <label for="password_confirmation">Confirm password *</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <small>Password must contain at least 8 characters</small>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </main>
  
  @yield('footer')

@endsection
