<form class="answer" method="post">
    <a href="../questions/{{ $answer->id_question }}">HERE</a>
    @csrf
    <div class="content-left">
        <img class="member-pfp answer-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}" alt="User's profule picture" />
        <div class="answers-votes">
            <span class="answer-upvotes">{{ $answer->likes_count}}
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
                </svg>
            </span>
            <span class="answer-downvotes">{{ $answer->dislikes_count }}
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
                </svg>
            </span>
        </div>
    </div>
    <article class="content-right">
        <header class="answer-info">
            <div class="answer-details">
                <a class="username" href="../users/{{ $answer->id_user }}">{{ $answer->user->username }}</a>
                @if (isset($answer->user->communitiesRating))
                    @foreach ($answer->user->communitiesRating as $communityRating)
                        @if ($communityRating->pivot->id_community == $answer->question->id_community && $communityRating->pivot->expert)
                            <img class="experts-stars" src="{{ asset('assets/rating-images/star-expert.png') }}" alt="Expert">
                        @endif
                        @if ($communityRating->pivot->id_community == $answer->question->id_community)
                            <p class="rating">{{ $communityRating->pivot->rating }} score</p>
                        @endif
                    @endforeach
                @endif
            </div>
            @if ($answer->correct)
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="40px" height="40px">
                    <path fill="#c8e6c9" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"/>
                    <path fill="#4caf50" d="M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z"/>
                </svg>
            @endif
        </header>
        <span class="date">Answer added {{ $answer->date }}</span>
        @if (Auth::user()?->id === $answer->id_user || Auth::user()?->administrator)
            <textarea class="description non-movable-textarea" name="content" cols="40" rows="5">{{ $answer->content }}</textarea>
        @else
            <p class="description">{{ $answer->content }}</p>
        @endif
        @if (Auth::user()?->id === $answer->id_user || Auth::user()?->administrator)
            @if ($answer->correct)
                <button class="mark-incorrect" formaction="../../answers/{{ $answer->id }}/incorrect">Remove correct mark</button>
            @else
                <button class="mark-correct" formaction="../../answers/{{ $answer->id }}/correct">Mark as correct</button>
            @endif
            <button class="edit" formaction="../../answers/{{ $answer->id }}">Edit</button>
            <button class="delete" formaction="../../answers/{{ $answer->id }}/delete">Delete</button>
        @endif
    </article>
</form>
