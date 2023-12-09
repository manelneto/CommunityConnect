@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main class="main-content">
        @yield('errors')
        <section id="create-question">
            <h1>Ask a Question</h1>
            <form action="{{ route('questions') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">Title</label>
                <input id="title" class="form-control" type="text" name="title" required placeholder="Enter the question's title">
                <label for="community">Choose a community</label>
                <select id="community" class="form-control" name="id_community" required>
                    @foreach ($communities as $community)
                        <option value="{{ $community->id }}">{{ $community->name }}</option>
                    @endforeach
                </select>
                <label for="content">Content</label>
                <textarea id="content" class="form-control" name="content"  placeholder="Elaborate your question" required></textarea>
                <label for="file">File</label>
                <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt">
                <input type="hidden" name="type" value="question">
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
@endsection
