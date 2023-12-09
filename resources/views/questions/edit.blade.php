@extends('layouts.app')
@include ('layouts.errors')

@php
    $disableTextArea = (in_array($question->id_community, Auth::user()?->moderatorCommunities->pluck('id')->toArray()) && $question->user->id != Auth::user()?->id );
@endphp

@section('main')
    <main id="question-edit">
        <div class="main-content">
            <section class="main-info">
                <span class="edit-question-text">Edit Question</span>
                <form class="question-container question-edit-container" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="horizontal-wrapper horizontal-wrapper-edit">
                        <img class="member-pfp question-member-pfp" src="{{ asset($question->user->image) }}" alt="User's profile picture" />
                        <div class="content-right">
                            <div class="question-details">
                                <a href="../users/{{ $question->id_user }}" class="question-username">{{ $question->user->username }}</a>
                                <span class="question-asked-date">Asked: {{ $question->date }}</span>
                                <span class="question-community">In: {{ $question->community->name }}</span>
                            </div>
                            <label for="title">Title</label>
                            <h2 class="question-title"><input id="title" class="question-title-edit" type="text" name="title" {{ $disableTextArea ? 'disabled' : '' }} value="{{ $question->title }}"></h2>
                            <label for="community">Community</label>
                            <select id="community" class="form-control" name="id_community" {{ $disableTextArea ? 'disabled' : '' }}>
                                <option value="{{ $question->id_community }}">{{ $question->community->name }}</option>
                                @foreach ($communities as $community)
                                    @if ($community->id !== $question->id_community)
                                        <option value="{{ $community->id }}">{{ $community->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label id="content-label" for="content">Content</label>
                            <textarea id="content" class="question-description non-movable-textarea" name="content" rows="6" cols="56" >{{ $question->content }}
                            </textarea>
                            <label for="file">File</label>
                            <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt" value="{{ asset($question->file) }}">
                            <input type="hidden" name="type" value="question">
                            <div class="edit-question-tags">
                                @foreach ($question->tags as $tag) 
                                    <li id="{{ $tag->id }}-{{ $question->id }}" class="question-tag margin-on-tags">
                                        {{ $tag->name }}
                                        <div class="tag-tooltip-content color-black">Delete this tag.</div>
                                    </li>
                                @endforeach
                                <input id="add-tag" class="form-control" type="text" name="add-tag" placeholder="Add a tag">
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
