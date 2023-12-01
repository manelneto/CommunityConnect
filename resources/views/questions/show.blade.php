@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="question-show">
        <div class="main-content">
            <section class="main-info">
                @include('partials.question', ['question' => $question])
                @auth
                    <div class="leave-answer-container">
                        <span class="leave-answer-text">Leave an Answer</span>
                        <form action="/answers" method="POST">
                            @csrf
                            <textarea id="content" name="content" rows="6" cols="60"></textarea>
                            <input type="hidden" name="id_question" value="{{ $question->id }}">
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            <input id="submit-answer" type="submit" value="Post Answer">
                        </form>
                    </div>
                @endauth
                @foreach ($answers as $answer)
                    @include('partials.answer', ['answer' => $answer])
                @endforeach
                @yield('errors')
            </section>
        </div>
    </main>
@endsection
