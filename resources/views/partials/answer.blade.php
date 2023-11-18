<form class="answer-container" method="post">
    @csrf
    <img class="member-pfp answer-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
        alt="User's profule picture" />
    <div class="content-right">
        <div class="answer-details">
            <a href="../users/{{ $answer->id_user }}" class="answer-username">{{ $answer->user->username }}</a>
            <span class="answer-asked-date">Asked: {{ $answer->date }}</span>
        </div>
        <p class="answer-description">{{ $answer->content }}</p>
        <textarea class="answer-description" name="content">{{ $answer->content }}</textarea>
        <div class="answers-details">
            <span class="answer-upvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
                </svg>
                {{ $answer->likes_count }}</span>
            <span class="answer-downvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
                </svg>
                {{ $answer->dislikes_count }}</span>
        </div>
    </div>
    <button formaction="../../answers/{{ $answer->id }}">Edit</button>
    <button formaction="../../answers/{{ $answer->id }}/delete">Delete</button>
</form>