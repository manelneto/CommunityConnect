@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@section('content')
    @yield('header')

@if ($errors->any())
        <div class="error-box">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
@endif
<form class="question-container" method="post">
    @csrf
    <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
         alt="User's profule picture" />
    <div class="content-right">
        <div class="question-details">
            <a href="#" class="question-username">{{ $question->user->username }}</a>
            <span class="question-asked-date">Asked: {{ $question->date }}</span>
            <span class="question-community">In: {{ $question->community->name }}</span>
        </div>
        <h2 class="question-title"><input type="text" name="title" required value="{{ $question->title }}"></h2>
        <textarea class="question-description" name="content">{{ $question->content }}</textarea>
        <div class="answers-details">
            <span class="question-upvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
                </svg>
                {{ $question->likes_count }}</span>
            <span class="question-downvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
                </svg>
                {{ $question->dislikes_count }}</span>
        </div>
    </div>
    <button formaction="../../questions/{{ $question->id }}">Edit</button>
    <button formaction="../../questions/{{ $question->id }}/delete">Delete</button>
</form>

    @yield('footer')
@endsection
