@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')
@include('layouts.right')

@section('content')
    <main>
        @yield('header')
        <div class="main-content">

            <nav class="menu-nav">
                @yield('main-navigation-list')
            </nav>
            <section class="main-info">

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <span class="edit-question-text">Edit Question</span>

                <form class="question-container question-edit-container" method="post">
                    @csrf
                    <div class="horizontal-wrapper horizontal-wrapper-edit">
                        <img class="member-pfp question-member-pfp"
                            src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                            alt="User's profule picture" />
                        <div class="content-right">
                            <div class="question-details">
                                <a href="#" class="question-username">{{ $question->user->username }}</a>
                                <span class="question-asked-date">Asked: {{ $question->date }}</span>
                                <span class="question-community">In: {{ $question->community->name }}</span>
                            </div>
                            <h2 class="question-title"><input class="question-title-edit" type="text" name="title"
                                    required value="{{ $question->title }}">
                            </h2>
                            <textarea class="question-description non-movable-textarea" name="content" rows="6" cols="56">{{ $question->content }}</textarea>
                        </div>
                    </div>
                    <div class="edit-buttons">
                        <button class="edit-button" formaction="../../questions/{{ $question->id }}">Edit</button>
                        <button class="delete-button"
                            formaction="../../questions/{{ $question->id }}/delete">Delete</button>
                    </div>
                </form>
            </section>
            @yield('right')
        </div>
    </main>
    @yield('footer')
@endsection
