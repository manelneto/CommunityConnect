@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')
@include('layouts.right')

@section('content')
    @yield('header')

    <main>
        <div class="main-content">

            <nav class="menu-nav">
                @yield('main-navigation-list')
            </nav>

            <section class="main-info">

                <!-- question -->

                @include('partials.question', ['question' => $question])

                <div class="leave-answer-container">
                    <button class="leave-answer-button">Leave an Answer</button>
                </div>

                <!-- answers -->

                @foreach ($answers as $answer)
                    @include('partials.answer', ['answer' => $answer])
                @endforeach

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @auth
                    <form action="/answers" method="POST">
                        @csrf
                        <label for="content">Your Answer:</label>
                        <textarea id="content" name="content" rows="4" cols="50"></textarea>
                        <br>
                        <input type="hidden" name="id_question" value="{{ $question->id }}">
                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                        <input type="submit" value="Post Answer">
                    </form>
                @endauth
            </section>
            @yield('right')
        </div>
    </main>

    @yield('footer')
@endsection
