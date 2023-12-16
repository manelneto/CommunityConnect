@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main id="create-question-page">
        @yield('errors')
        <section id="create-question">
            <section class="add-tooltip" id="add-question-tooltip-section">
                <h1>Ask a Question</h1>
                <div class="tooltip-icon" id="user-edit-profile">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">
                        To post a question, write a title describing it in the <b>Title</b> field.
                        Then, choose a community from the <b>Choose a community</b> dropdown menu.
                        Finally, elaborate your question in the <b>Content</b> field.
                        You can also attach a file to your question by clicking on the <b>File</b> button and selecting one.
                        When you're done, click on the <b>Submit</b> button.
                    </p>
                </div>
            </section>
            <form action="{{ route('questions') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">Title</label>
                <input id="title" class="form-control" type="text" name="title" required placeholder="Enter the question's title">
                <label for="community">Choose a community</label>
                <select id="community" class="form-control" name="id_community" required>
                    <!-- TODO -->
                    @foreach ($communities as $community)
                        <option value="{{ $community->id }}">{{ $community->name }}</option>
                    @endforeach
                </select>
                <label for="content">Content</label>
                <textarea id="content" class="form-control" name="content" placeholder="Elaborate your question" required></textarea>
                <label for="file">File</label>
                <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt">
                <input type="hidden" name="type" value="question">
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
@endsection
