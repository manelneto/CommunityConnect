@extends('layouts.app')

@section('main')
<main id="question">
    @include('partials.question', ['question' => $question])
    <section class="comments">
        <h3>Question Comments</h3>
        @foreach ($question->comments as $comment)
            @include('partials.question_comment', ['comment' => $comment])
        @endforeach
        @can ('create', App\Models\QuestionComment::class)
            <article class="add-tooltip-comment">
                <h3>Contextual Help</h3>
                <p class="add-question-comment-tap">Comment this question...</p>
                <div class="tooltip-icon">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">You can add a comment by writing it in the field and clicking on the <b>Post Comment</b> button. Use this to ask for more information or to clarify something.</p>
                </div>
            </article>
            <form class="leave-comment leave-comment-question hidden" action="{{ route('question-comments') }}" method="post">
                @csrf
                <label for="question-comment">Content</label>
                <input id="question-comment" name="content" placeholder="Type in your comment here">
                <input type="hidden" name="id_question" value="{{ $question->id }}">
                <button class="submit-comment" type="submit">Post Comment</button>
            </form>
        @endcan
    </section>
    @can ('create', App\Models\Answer::class)
        <section class="leave">
            <h2>Leave an Answer</h2>
            <article class="add-tooltip">
                <h2 id="leave-answer-on-question">Leave an Answer</h2>
                <div class="tooltip-icon">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">You can answer the question above by writing your answer in the <b>Content</b> field and clicking on the <b>Post Answer</b> button. You can also attach a file to your answer by clicking on the <b>File</b> button and selecting one.</p>
                </div>
            </article>
            <form action="{{ route('answers') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="6" cols="60" placeholder="Enter your answer here"></textarea>
                <input type="hidden" name="id_question" value="{{ $question->id }}">
                <label for="file">File</label>
                <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt">
                <input type="hidden" name="type" value="answer">
                <button type="submit">Post Answer</button>
            </form>
        </section>
    @endcan
    <section id="answers">
        <h2>Answers</h2>
        <article class="add-tooltip">
            <h2 class="ignore-tooltip-h2-changes">{{ $question->answers_count }} Answers</h2>
            <div class="tooltip-icon">
                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                    <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                </svg>
                <p class="tooltip-text">The author of the question can mark one of the answers as correct by clicking on the <b>Mark as Correct</b> button. This will make a green checkmark appear next to the answer.</p>
            </div>
        </article>
        @foreach ($answers as $answer)
            <section class="answer-container">
                <h2>Answer</h2>
                @include('partials.answer', ['answer' => $answer])
                <section class="comments">
                    <h3>Answer Comments</h3>
                    @foreach($answer->comments as $comment)
                        @include('partials.answer_comment', ['comment' => $comment])
                    @endforeach
                    @can ('create', App\Models\AnswerComment::class)
                        <p class="add-answer-comment-tap">Comment this answer...</p>
                        <form class="leave-comment leave-answer-comment leave-comment-question hidden" action="{{ route('answer-comments') }}" method="post">
                            @csrf
                            <label for="answer-comment-{{ $answer->id }}">Content</label>
                            <input id="answer-comment-{{ $answer->id }}" class="answer-comment" name="content" placeholder="Type in your comment here">
                            <input type="hidden" name="id_answer" value="{{ $answer->id }}">
                            <button class="submit-comment" type="submit">Post Comment</button>
                        </form>
                    @endcan
                </section>
            </section>
        @endforeach
    </section>
</main>
@endsection
