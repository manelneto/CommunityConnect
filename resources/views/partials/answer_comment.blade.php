@if (Auth::user()?->id === $comment->id_user || Auth::user()?->administrator || Auth::user()?->moderates($comment->answer->question->id_community))
    <form class="comment edit-answer-comment" method="post">
        @csrf
        <div class="comments-details">
            <a class="username edit-answer-comment-username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
            <p class="date edit-answer-comment-date">{{ $comment->date }}</p>
        </div>
        <div id="content-comment">
            <input class="description non-movable-textarea edit-answer-comment-content" name="content" value="{{ $comment->content }}">
            <button class="edit" formaction="../../answer-comments/{{ $comment->id }}">Edit</button>
            <button class="delete" formaction="../../answer-comments/{{ $comment->id }}/delete">Delete</button>
        </div>
    </form>
@else
    <article class="comment-not-edit-answer">
        <a class="username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
        <p class="date edit-question-comment-date">{{ $comment->date }}</p>
        <p class="description"> - {{ $comment->content }}</p>
    </article>
@endif
