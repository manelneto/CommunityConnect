@can ('edit', $comment)
    <form class="comment edit-question-comment" method="post">
        @csrf
        <input class="description non-movable-textarea edit-question-comment-content" name="content" value="{{ $comment->content }}">
        <a class="username edit-question-comment-username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
        
        <!-- Moderator Badge -->

        @if (in_array($comment->question->community->id, $comment->user->moderatorCommunities->pluck('id')->toArray()))
            <svg class="moderator-badge-answer" width="23" height="23" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_378_1879)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M47.5 3.7104e-05L57.5 0C58.163 -2.38415e-06 58.7987 0.263387 59.2677 0.732227C59.7365 1.20106 60 1.83695 60 2.49999V12.5C60 13.1631 59.7365 13.7989 59.2677 14.2678L29.7855 43.75L34.2677 48.2323C35.244 49.2085 35.244 50.7915 34.2677 51.7677C33.2915 52.7442 31.7085 52.7442 30.7323 51.7677L24.4822 45.5177L23.6594 44.695L14.9997 52.4888C15.0024 54.4088 14.2718 56.335 12.8033 57.8035C9.87437 60.7325 5.12562 60.7325 2.1967 57.8035C-0.732233 54.8745 -0.732233 50.1258 2.1967 47.1968C3.66517 45.7283 5.59117 44.9978 7.51127 45.0005L15.305 36.3407L14.4822 35.5177L8.23222 29.2677C7.25592 28.2915 7.25592 26.7085 8.23222 25.7323C9.20855 24.756 10.7914 24.756 11.7678 25.7323L16.2499 30.2145L45.7323 0.732267C46.201 0.26343 46.837 3.9488e-05 47.5 3.7104e-05ZM19.7855 33.75L20.5177 34.4823L25.5177 39.4823L26.25 40.2145L55 11.4645V5L48.5355 5.00003L19.7855 33.75ZM18.8455 39.881L12.5109 46.9195C12.6103 47.0087 12.7078 47.1013 12.8033 47.1968C12.8988 47.2923 12.9912 47.3898 13.0805 47.4893L20.119 41.1545L18.8455 39.881ZM8.0169 50.0535C7.21112 49.885 6.35022 50.1145 5.73222 50.7325C4.75592 51.7087 4.75592 53.2915 5.73222 54.268C6.70855 55.2442 8.29145 55.2442 9.26777 54.268C9.88577 53.65 10.1152 52.789 9.94655 51.9833C9.8508 51.5258 9.62687 51.0915 9.26777 50.7325C8.90865 50.3732 8.47425 50.1493 8.0169 50.0535Z" fill="#43DB1D"/>
                </g>
                <defs>
                <clipPath id="clip0_378_1879">
                <rect width="60" height="60" fill="white"/>
                </clipPath>
                </defs>
            </svg>
        @endif

        <p class="date edit-question-comment-date">{{ $comment->date }}</p>
        <button class="edit" formaction="../../question-comments/{{ $comment->id }}">Edit</button>
        <button class="delete" formaction="../../question-comments/{{ $comment->id }}/delete">Delete</button>
    </form>
@else
    <article class="comment">
        <p class="description">{{ $comment->content }} -
            <a class="username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
            
            <!-- Moderator Badge -->

            @if (in_array($comment->question->community->id, $comment->user->moderatorCommunities->pluck('id')->toArray()))
                <svg class="moderator-badge-answer" width="23" height="23" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_378_1879)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M47.5 3.7104e-05L57.5 0C58.163 -2.38415e-06 58.7987 0.263387 59.2677 0.732227C59.7365 1.20106 60 1.83695 60 2.49999V12.5C60 13.1631 59.7365 13.7989 59.2677 14.2678L29.7855 43.75L34.2677 48.2323C35.244 49.2085 35.244 50.7915 34.2677 51.7677C33.2915 52.7442 31.7085 52.7442 30.7323 51.7677L24.4822 45.5177L23.6594 44.695L14.9997 52.4888C15.0024 54.4088 14.2718 56.335 12.8033 57.8035C9.87437 60.7325 5.12562 60.7325 2.1967 57.8035C-0.732233 54.8745 -0.732233 50.1258 2.1967 47.1968C3.66517 45.7283 5.59117 44.9978 7.51127 45.0005L15.305 36.3407L14.4822 35.5177L8.23222 29.2677C7.25592 28.2915 7.25592 26.7085 8.23222 25.7323C9.20855 24.756 10.7914 24.756 11.7678 25.7323L16.2499 30.2145L45.7323 0.732267C46.201 0.26343 46.837 3.9488e-05 47.5 3.7104e-05ZM19.7855 33.75L20.5177 34.4823L25.5177 39.4823L26.25 40.2145L55 11.4645V5L48.5355 5.00003L19.7855 33.75ZM18.8455 39.881L12.5109 46.9195C12.6103 47.0087 12.7078 47.1013 12.8033 47.1968C12.8988 47.2923 12.9912 47.3898 13.0805 47.4893L20.119 41.1545L18.8455 39.881ZM8.0169 50.0535C7.21112 49.885 6.35022 50.1145 5.73222 50.7325C4.75592 51.7087 4.75592 53.2915 5.73222 54.268C6.70855 55.2442 8.29145 55.2442 9.26777 54.268C9.88577 53.65 10.1152 52.789 9.94655 51.9833C9.8508 51.5258 9.62687 51.0915 9.26777 50.7325C8.90865 50.3732 8.47425 50.1493 8.0169 50.0535Z" fill="#43DB1D"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_378_1879">
                    <rect width="60" height="60" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            @endif
            
            <span class="date">{{ $comment->date }}</span>
        </p>
    </article>
@endcan
