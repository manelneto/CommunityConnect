@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="question">
        @yield('errors')
        @include('partials.question', ['question' => $question])
        <details class="comments">
            <summary>Question Comments</summary>
            @foreach ($question->comments as $comment)
                @include('partials.question_comment', ['comment' => $comment])
            @endforeach
            <article class="leave">
                <h2>Leave a Comment</h2>
                <form action="/question-comments" method="post">
                    @csrf
                    <textarea name="content" rows="6" cols="60" placeholder="Type in your comment here"></textarea>
                    <input type="hidden" name="id_question" value="{{ $question->id }}">
                    <button type="submit">Post Comment</button>
                </form>
            </article>
        </details>
        @auth
            <article class="leave">
                <h2 class="leave-answer-text">Leave an Answer</h2>
                <form action="/answers" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="6" cols="60" placeholder="Enter your answer here"></textarea>
                    <input type="hidden" name="id_question" value="{{ $question->id }}">
                    <label for="file">File</label>
                    <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt">
                    <input type="hidden" name="type" value="answer">
                    <button type="submit">Post Answer</button>
                </form>
            </article>
        @endauth
        <section id="answers">
            <h2> {{ $question->answers_count }} Answers</h2>
            @foreach ($answers as $answer)
                @include('partials.answer', ['answer' => $answer])
                <details class="comments">
                    <summary>Answer Comments</summary>
                    @foreach($answer->comments as $comment)
                        @include('partials.answer_comment', ['comment' => $comment])
                    @endforeach
                    <article class="leave">
                        <h2>Leave a Comment</h2>
                        <form action="/answer-comments" method="post">
                            @csrf
                            <textarea name="content" rows="6" cols="60" placeholder="Type in your comment here"></textarea>
                            <input type="hidden" name="id_answer" value="{{ $answer->id }}">
                            <button type="submit">Post Comment</button>
                        </form>
                    </article>
                </details>
            @endforeach
        </section>
    </main>
@endsection
