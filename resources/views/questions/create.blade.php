@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main class="main-content">
        @yield('errors')
        <section id="create-question">
            <h1>Ask a Question</h1>
            <form action="{{ route('questions') }}" method="post">
                @csrf
                    <label for="title">Title</label>
                    <input id="title" class="form-control" type="text" name="title" required>
                    <label for="community">Choose a community</label>
                    <select id="community" class="form-control" name="id_community" required>
                        @foreach ($communities as $community)
                            <option value="{{ $community->id }}">{{ $community->name }}</option>
                        @endforeach
                    </select>
                    <label for="content">Content</label>
                    <textarea id="content" class="form-control" name="content"  placeholder="Describe your question" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
@endsection
