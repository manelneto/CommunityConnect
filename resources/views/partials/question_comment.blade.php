@if (Auth::user()?->id === $comment->id_user || Auth::user()?->administrator)
    <form class="comment" method="post">
        @csrf
        <textarea class="description non-movable-textarea" name="content">{{ $comment->content }}</textarea>
        <a class="username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
        <p class="date">{{ $comment->date }}</p>
        <button class="edit" formaction="../../question-comments/{{ $comment->id }}">Edit</button>
        <button class="delete" formaction="../../question-comments/{{ $comment->id }}/delete">Delete</button>
    </form>
@else
    <article class="comment">
        <h3>Comment</h3>
        <p class="description">{{ $comment->content }}</p>
        <a class="username" href="../users/{{ $comment->id_user }}">{{ $comment->user->username }}</a>
        <p class="date">{{ $comment->date }}</p>
    </article>
@endif
