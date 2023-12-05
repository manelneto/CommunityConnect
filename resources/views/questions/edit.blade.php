@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="question-edit">
        <div class="main-content">
            <section class="main-info">
                @yield('errors')
                <span class="edit-question-text">Edit Question</span>
                <form class="question-container question-edit-container" method="post">
                    @csrf
                    <div class="horizontal-wrapper horizontal-wrapper-edit">
                        <img class="member-pfp question-member-pfp" src="{{ asset($user->image) }}" alt="User's profile picture" />
                        <div class="content-right">
                            <div class="question-details">
                                <a href="#" class="question-username">{{ $question->user->username }}</a>
                                <span class="question-asked-date">Asked: {{ $question->date }}</span>
                                <span class="question-community">In: {{ $question->community->name }}</span>
                            </div>
                            <h2 class="question-title"><input class="question-title-edit" type="text" name="title" required value="{{ $question->title }}"></h2>
                            <textarea class="question-description non-movable-textarea" name="content" rows="6" cols="56">{{ $question->content }}</textarea>
                        </div>
                    </div>
                    <div class="edit-buttons">
                        <button class="edit-button" formaction="../../questions/{{ $question->id }}">Edit</button>
                        <button class="delete-button" formaction="../../questions/{{ $question->id }}/delete">Delete</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection
