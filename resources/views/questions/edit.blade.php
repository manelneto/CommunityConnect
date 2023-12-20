@extends('layouts.app')

@section('main')
    <main id="question-edit" class="main-content main-info">
        <section id="add-question-tooltip-section" class="add-tooltip">
            <h1 class="edit-question-text">Edit Question</h1>
            <div class="tooltip-icon" id="user-edit-profile">
                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                    <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                </svg>
                <p class="tooltip-text">To edit a question, you can change its title, community, content and file, by clicking the respective fields and changing them. You can also add or remove tags. When you're done, click on the <b>Edit</b> button. You can also delete the question by clicking on the <b>Delete</b> button.</p>
            </div>
        </section>
        <form class="question-edit-container" method="post" enctype="multipart/form-data">
            @csrf
            <article class="horizontal-wrapper horizontal-wrapper-edit">
                <h2>Edit Question</h2>
                <img class="member-pfp question-member-pfp" src="{{ asset($question->user->image) }}" alt="User's profile picture">
                <article class="edit-question-info">
                    <h2>Edit Question</h2>
                    <header class="question-details">
                        <a href="../users/{{ $question->id_user }}" class="question-username">{{ $question->user->username }}</a>
                        <p class="question-asked-date">Asked: {{ $question->date }}</p>
                        <p class="question-community">In: {{ $question->community->name }}</p>
                    </header>
                    <label for="title">Title</label>
                    <input id="title" class="question-title question-title-edit" type="text" name="title" value="{{ $question->title }}" placeholder="Enter the question's title here">
                    <label for="community">Community</label>
                    <select id="community" class="form-control" name="id_community">
                        <option value="{{ $question->id_community }}">{{ $question->community->name }}</option>
                        @foreach ($communities as $community)
                            @if ($community->id !== $question->id_community)
                                <option value="{{ $community->id }}">{{ $community->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label id="content-label" for="content">Content</label>
                    <textarea id="content" class="question-description non-movable-textarea" name="content" rows="6" cols="56" placeholder="Elaborate your question">{{ $question->content }}</textarea>
                    <section id="property-tags" class="edit-question-tags">
                        <h3>Tags</h3>
                        <label for="add-tag">Tags</label>
                        <input id="add-tag" class="form-control" type="text" name="add-tag" placeholder="Enter the tag name, click Tab for autocomplete and Enter to add more tags">
                        @foreach ($question->tags as $tag)
                            <div id="{{ $tag->id }}" class="all-tags">
                                <button class="all-buttons">X</button>{{ $tag->name }}
                                <input type="hidden" name="tags-{{ $tag->id}}" value="{{ $tag->id }}">
                            </div>
                        @endforeach
                    </section>
                    <label for="file">File</label>
                    <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt">
                    <input type="hidden" name="type" value="question">
                </article>
            </article>
            <div class="edit-buttons">
                <button class="edit-button" formaction="{{ route('update-question', ['id' => $question->id]) }}">Edit</button>
                <button class="delete-button" formaction="{{ route('delete-question', ['id' => $question->id]) }}">Delete</button>
            </div>
        </form>
    </main>
@endsection
