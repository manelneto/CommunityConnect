@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main>
        @yield('errors')
        <div class="main-content">
            <section id="create-question">
                <h1>Ask a Question</h1>
                <form action="{{ route('questions') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" class="form-control" type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea id="content" class="form-control" name="content"  placeholder="Describe your question" required></textarea>
                    </div>
                    <input id="id_user" type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                    <input id="id_community" type="hidden" name="id_community" value="1">
                    <button type="submit">Submit</button>
                </form>
            </section>
        </div>
    </main>
@endsection
