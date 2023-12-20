@can ('edit', $comment)
    <form class="comment edit-answer-comment" method="post">
        @csrf
        <header class="comments-details">
            <a class="username edit-answer-comment-username" href="{{ route('profile', ['id' => $comment->id_user]) }}">{{ $comment->user->username }}</a>
            <p class="date edit-answer-comment-date">{{ $comment->date }}</p>
            @if ($comment->last_edited !== null)
                <p class="date edit-question-comment-date edited-date">Edited: {{ $comment->last_edited }}</p>
            @endif
        </header>
        <footer id="content-comment">
            <label for="question-comment-{{ $comment->id }}">Content</label>
            <input id="question-comment-{{ $comment->id }}" class="description non-movable-textarea edit-answer-comment-content" name="content" value="{{ $comment->content }}">
            <button class="edit" formaction="../../answer-comments/{{ $comment->id }}">Edit</button>
            <button class="delete" formaction="../../answer-comments/{{ $comment->id }}/delete">Delete</button>
        </footer>
    </form>
@else
    <article class="comment-not-edit-answer">
        <h3>Comment</h3>
        <a class="username" href="{{ route('profile', ['id' => $comment->id_user]) }}">{{ $comment->user->username }}</a>
        <p class="date edit-question-comment-date">{{ $comment->date }}</p>
        @if ($comment->last_edited !== null)
            <p class="date edit-question-comment-date edited-date">Edited: {{ $comment->last_edited }}</p>
        @endif
        <p class="description"> - {{ $comment->content }}</p>
    </article>
@endcan
