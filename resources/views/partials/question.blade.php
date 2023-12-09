<div class="question-container">
    <img class="member-pfp question-member-pfp" src="{{ asset($question->user->image) }}" alt="User's profile picture" />
    <div class="content-right">
        <div class="question-details">
            <a href="../users/{{ $question->id_user }}" class="question-username">{{ $question->user->username }}</a>
            <span class="question-asked-date">Asked: {{ $question->date }}</span>
            <span class="question-community">In: {{ $question->community->name }}</span>
            @if( $question->last_edited != null)
                <p class="question-edited-date">Edited: {{ $question->last_edited }}</p>
            @endif
            @if (Request::route()->getName() == 'question' && Auth::user())
                @if (Auth::user()?->followedQuestions->contains($question->id))
                    <button id="{{ $question->id }}" class="unfollow-question-button">
                        <svg width="30" height="30" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"/>
                        </svg>
                    </button>
                    <span class="follow-question-tooltip">Unfollow this question.</span>
                @else
                    <button id="{{ $question->id }}" class="follow-question-button">
                        <svg width="30" height="30" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"/>
                        </svg>
                    </button>
                    <span class="follow-question-tooltip">Follow this question.</span>
                @endif
            @endif             
        </div>
        <h2 class="question-title"><a href="../questions/{{ $question->id }}">{{ $question->title }}</a></h2>
        <p class="question-description">
            {{ $question->content }}

            <!-- Edit Question Button -->

            @if (Request::route()->getName() == 'question' && 
            (
                $question->id_user == Auth::user()?->id ||
                Auth::user()?->administrator ||
                in_array($question->id_community, Auth::user()?->moderatorCommunities->pluck('id')->toArray() ?? [])
            ))
            <a href="{{ route('edit-question', ['id' => $question->id]) }}" class="edit-question-button">Edit</a>
            @endif

        </p>
        @if ($question->file)
            <p class="file">Download file <a href="{{ asset($question->file) }}" target="_blank">here</a></p>
        @endif
        <div class="answers-details">
            @if (Request::route()->getName() == 'questions')
                <button class="question-answer-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z" fill="#abacb1" />
                    </svg>
                    {{ $question->answers_count }} Answers
                </button>
            @endif
            <span class="question-upvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
                </svg>
                {{ $question->likes_count }}
            </span>
            <span class="question-downvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
                </svg>
                {{ $question->dislikes_count }}
            </span>
            @if (Request::route()->getName() == 'question' or Request::route()->getName() == 'edit-question')
                <ul class="question-tags">
                    @foreach ($question->tags as $tag)
                        <li class="question-tag">
                            <div class="tag-tooltip-content">
                                <a class="watch-tag-button" href="/questions?text=%5B{{ $tag->name }}%5D">
                                    <svg width="20" height="20" viewBox="0 0 61 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M37.8904 30.8372C37.8904 34.9794 34.5327 38.3372 30.3904 38.3372C26.2484 38.3372 22.8905 34.9794 22.8905 30.8372C22.8905 26.6949 26.2484 23.3372 30.3904 23.3372C34.5327 23.3372 37.8904 26.6949 37.8904 30.8372Z" stroke="black" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M30.3917 13.3372C19.1975 13.3372 9.72183 20.6944 6.53613 30.8372C9.72178 40.9799 19.1975 48.3372 30.3917 48.3372C41.5857 48.3372 51.0614 40.9799 54.2472 30.8372C51.0614 20.6944 41.5857 13.3372 30.3917 13.3372Z" stroke="black" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Watch tag</a>
                                @if (Auth::user()?->followedTags->contains($tag->id))
                                    <button id="{{$tag->id}}" class="unfollow-tag-button">
                                        <svg width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"></path>
                                        </svg>
                                        <span> Unfollow tag </span></button>
                                @else
                                    <button id="{{$tag->id}}" class="follow-tag-button">
                                        <svg width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"></path>
                                        </svg>
                                        <span> Follow tag </span></button>
                                @endif
                            </div>
                        {{ $tag->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
