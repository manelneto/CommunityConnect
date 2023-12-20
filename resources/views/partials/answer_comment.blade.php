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
        <footer class="content-comment">
            <label for="answer-comment-{{ $comment->id }}">Content</label>
            <input id="answer-comment-{{ $comment->id }}" class="description non-movable-textarea edit-answer-comment-content" name="content" value="{{ $comment->content }}">
            <button class="edit" formaction="{{ route('edit-answer-comment', ['id' => $comment->id]) }}">Edit</button>
            <button class="delete" formaction="{{ route('delete-answer-comment', ['id' => $comment->id]) }}">Delete</button>
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
