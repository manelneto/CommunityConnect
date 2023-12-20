<article class="question-container">
    <h3>Question</h3>
    <img class="member-pfp question-member-pfp" src="{{ asset($question->user->image) }}" alt="User's profile picture"/>
    <article class="content-right">
        <h3>Question</h3>
        <header class="question-details">
            <a class="question-username" href="{{ route('profile', ['id' => $question->id_user]) }}">{{ $question->user->username }}</a>
            <p class="question-asked-date">Asked: {{ $question->date }}</p>
            <p class="question-community">In: <a class="question-community-click" href="{{ route('community', ['id' => $question->community->id]) }}">{{ $question->community->name }}</a></p>
            @if ($question->last_edited !== null)
                <p class="question-edited-date">Edited: {{ $question->last_edited }}</p>
            @endif
            @if (Request::routeIs('question'))
                @can ('edit', $question)
                    <a href="{{ route('edit-question', ['id' => $question->id]) }}" class="edit-question-button">Edit</a>
                @endcan
            @endif
            @if (Request::routeIs('question'))
                @if (Auth::user()?->followedQuestions->contains($question->id))
                    @can ('unfollow', App\Models\Question::class)
                        <button id="{{ $question->id }}" class="unfollow-question-button">
                            <svg width="30" height="30" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"/>
                            </svg>
                        </button>
                        <p class="follow-question-tooltip">Unfollow this question</p>
                    @endcan
                @else
                    @can ('follow', App\Models\Question::class)
                        <button id="{{ $question->id }}" class="follow-question-button">
                            <svg width="30" height="30" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"/>
                            </svg>
                        </button>
                        <p class="follow-question-tooltip">Follow this question</p>
                    @endcan
                @endif
            @endif
        </header>
        <h2 class="question-title"><a href="{{ route('question', ['id' => $question->id]) }}">{{ $question->title }}</a></h2>
        @foreach (explode(PHP_EOL, $question->content) as $paragraph)
            <p class="question-description">{{ $paragraph }}</p>
        @endforeach
        @if ($question->file)
            <p class="file"><a href="{{ asset($question->file) }}" target="_blank">Download file here</a></p>
        @endif
        <footer class="answers-details">
            <a class="question-answer-btn" href="{{ route('question', ['id' => $question->id]) . '#answers' }}" >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z" fill="#abacb1"/>
                </svg>
                {{ $question->answers_count }} Answers
            </a>
            <p class="question-upvotes" data-id="{{ $question->id }}">
                @if (((Request::routeIs('question') || Request::routeIs('profile')) && in_array(Auth::user()?->id, array_column($question->likes()->get()->toArray(), 'id_user'))) || (!Request::routeIs('question') && !Request::routeIs('profile') && in_array(Auth::user()?->id, array_column($question->likes, 'id_user'))))
                    <svg class="voted" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF"/>
                    </svg>
                @else
                    <svg class="unvoted" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#ABACB1"/>
                    </svg>
                @endif
                {{ $question->likes_count }}
            </p>
            <p class="question-downvotes" data-id="{{ $question->id }}">
                @if (((Request::routeIs('question') || Request::routeIs('profile')) && in_array(Auth::user()?->id, array_column($question->dislikes()->get()->toArray(), 'id_user'))) || (!Request::routeIs('question') && !Request::routeIs('profile') && in_array(Auth::user()?->id, array_column($question->dislikes, 'id_user'))))
                    <svg class="voted" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#38B6FF"/>
                    </svg>
                @else
                    <svg class="unvoted" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1"/>
                    </svg>
                @endif
                {{ $question->dislikes_count }}
            </p>
            @if (Request::routeIs('question') || Request::routeIs('edit-question'))
                <ul class="question-tags">
                    @foreach ($question->tags as $tag)
                        @include('partials.tag', ['tag' => $tag])
                    @endforeach
                </ul>
            @endif
        </footer>
    </article>
</article>
