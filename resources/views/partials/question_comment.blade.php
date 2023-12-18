@can ('edit', $comment)
    <form class="comment edit-question-comment" method="post">
        @csrf
        <div class="comments-details">
            <a class="username edit-question-comment-username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
            <p class="date edit-question-comment-date">{{ $comment->date }}</p>
            @if ($comment->last_edited != null)
                <p class="date edit-question-comment-date edited-date">edited {{ $comment->last_edited }}</p>
            @endif
        </div>
        <div id="content-comment">
            <input class="description non-movable-textarea edit-question-comment-content" name="content" value="{{ $comment->content }}">        
            <button class="edit" formaction="../../question-comments/{{ $comment->id }}">Edit</button>
            <button class="delete" formaction="../../question-comments/{{ $comment->id }}/delete">Delete</button>
        </div>
    </form>
@else
    <article class="comment-not-edit">
        <a class="username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
        <p class="date edit-question-comment-date">{{ $comment->date }}</p>
        @if ($comment->last_edited != null)
            <p class="date edit-question-comment-date edited-date">edited {{ $comment->last_edited }}</p>
        @endif
        <p class="description"> - {{ $comment->content }}</p>
    </article>
@endcan
