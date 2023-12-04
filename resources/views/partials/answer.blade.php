<form class="answer" method="post">
    @csrf
    <div class="content-left">
        <img class="member-pfp answer-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}" alt="User's profule picture" />
        <div class="answers-votes">
            <span class="answer-upvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
                </svg>
            </span>
            <span class="answer-vote-balance">{{ $answer->likes_count - $answer->dislikes_count }}</span>
            <span class="answer-downvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
                </svg>
            </span>
        </div>
    </div>
    <div class="content-right">
        <a class="username" href="../users/{{ $answer->id_user }}">{{ $answer->user->username }}</a>
        <span class="date">Answer added {{ $answer->date }}</span>
        @if (Auth::user()?->id === $answer->id_user || Auth::user()?->administrator)
            <textarea class="description non-movable-textarea" name="content" cols="40" rows="5">{{ $answer->content }}</textarea>
        @else
            <p class="description">{{ $answer->content }}</p>
        @endif
        @if (Auth::user()?->id === $answer->id_user || Auth::user()?->administrator)
            <button class="mark-correct" formaction="../../answers/{{ $answer->id }}/correct">Mark as correct</button>
            <button class="edit" formaction="../../answers/{{ $answer->id }}">Edit</button>
            <button class="delete" formaction="../../answers/{{ $answer->id }}/delete">Delete</button>
        @endif
    </div>
</form>
