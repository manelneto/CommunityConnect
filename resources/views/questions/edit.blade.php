@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="question-edit">
        <div class="main-content">
            <section class="main-info">
                <span class="edit-question-text">Edit Question</span>
                <form class="question-container question-edit-container" method="post">
                    @csrf
                    <div class="horizontal-wrapper horizontal-wrapper-edit">
                        <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}" alt="User's profule picture" />
                        <div class="content-right">
                            <div class="question-details">
                                <a href="#" class="question-username">{{ $question->user->username }}</a>
                                <span class="question-asked-date">Asked: {{ $question->date }}</span>
                                <span class="question-community">In: {{ $question->community->name }}</span>
                            </div>
                            <h2 class="question-title"><input class="question-title-edit" type="text" name="title" required value="{{ $question->title }}"></h2>
                            <textarea class="question-description non-movable-textarea" name="content" rows="6" cols="56">{{ $question->content }}</textarea>
                            <div class="edit-question-tags">
                                @foreach ($question->tags as $tag) 
                                    <li class="question-tag margin-on-tags">
                                        {{ $tag->name }}
                                    </li>
                                @endforeach
                                <input id="add-tag" class="form-control" type="text" name="add-tag">
                                @error('tag')
                                    <span class="error-message-tag-add">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>  
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
