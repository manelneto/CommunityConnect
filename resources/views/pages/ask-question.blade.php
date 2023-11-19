@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@section('content')
    <!-- <script src="./script.js"></script> -->

    @yield('header')
    <main>
    @if ($errors->any())
        <div class="error-box">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
    @endif
    <form action="{{ route('questions') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Question</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>

        <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}">
        <input type="hidden" name="id_community" id="id_community" value="1">


        </div>

        <button type="submit" class="btn btn-primary">Publish</button>
    </form>
    </main>
    @yield('footer')
@endsection