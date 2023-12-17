@extends('layouts.app')
@include ('layouts.errors')

@section('main')
<main id="question">
    @yield('errors')

    <!-- Question -->

    @include('partials.question', ['question' => $question])

    <!-- Question Comments -->
    
    <div class="comments">
        @foreach ($question->comments as $comment)
            @include('partials.question_comment', ['comment' => $comment])
        @endforeach
        @can ('create', App\Models\QuestionComment::class)
            <p class="add-question-comment-tap">Add comment...</p>
            <article class="leave leave-comment leave-comment-question hidden">
                <section class="add-tooltip">
                    <h2>Leave a Comment</h2>
                    <div class="tooltip-icon">
                        <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                            <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                        </svg>
                        <p class="tooltip-text">
                            You can add a comment to this question by writing it in the <b>Content</b> field and clicking on the <b>Post Comment</b> button.
                            Use this to ask for more information or to clarify something.
                        </p>
                    </div>
                </section>
                <form action="/question-comments" method="post">
                    @csrf
                    <label for="question-comment">Content</label>
                    <input id="question-comment" name="content" rows="2" cols="60" placeholder="Type in your comment here"></input>
                    <input type="hidden" name="id_question" value="{{ $question->id }}">
                    <button type="submit">Post Comment</button>
                </form>
            </article>
        @endcan
    </div>
    @can ('create', App\Models\Answer::class)
        <article class="leave">
            <section class="add-tooltip">
                <h2>Leave an Answer</h2>
                <div class="tooltip-icon">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">
                        You can answer the question above by writing your answer in the <b>Content</b> field and clicking on the <b>Post Answer</b> button.
                        You can also attach a file to your answer by clicking on the <b>File</b> button and selecting one.
                        Your answer should be a solution to the question, and can then be upvoted by other users, as well as marked as correct by the question's author.
                    </p>
                </div>
            </section>
            <form action="/answers" method="post" enctype="multipart/form-data">
                @csrf
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="6" cols="60" placeholder="Enter your answer here"></textarea>
                <input type="hidden" name="id_question" value="{{ $question->id }}">
                <label for="file">File</label>
                <input id="file" type="file" name="file" accept="image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt">
                <input type="hidden" name="type" value="answer">
                <button type="submit">Post Answer</button>
            </form>
        </article>
    @endcan

    <!-- Answers -->

    <section id="answers">
        <section class="add-tooltip">
            <h2 class="ignore-tooltip-h2-changes">{{ $question->answers_count }} Answers</h2>
                <div class="tooltip-icon">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">
                        The creator of the question can mark one of the answers as correct by clicking on the <b>Mark as Correct</b> button.
                        This will make a green checkmark appear next to the answer.
                    </p>
                </div>
            </section>
        @foreach ($answers as $answer)
            <div class="answer-container">
                @include('partials.answer', ['answer' => $answer])
                <div class="comments">
                    @foreach($answer->comments as $comment)
                        @include('partials.answer_comment', ['comment' => $comment])
                    @endforeach
                    @can ('create', App\Models\AnswerComment::class)
                        <p class="add-answer-comment-tap">Add comment...</p>
                        <article class="leave leave-comment leave-answer-comment hidden">
                            <section class="add-tooltip">
                                <h2>Leave a Comment</h2>
                                <div class="tooltip-icon">
                                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                                    </svg>
                                    <p class="tooltip-text">
                                        You can add a comment to this answer by writing it in the <b>Content</b> field and clicking on the <b>Post Comment</b> button.
                                        Use this to critique/vouch for the answer or to ask for more information.
                                    </p>
                                </div>
                            </section>
                                <form action="/answer-comments" method="post">
                                    @csrf
                                    <label for="answer-comment">Content</label>
                                    <input id="answer-comment" name="content" placeholder="Type in your comment here"></input>
                                    <input type="hidden" name="id_answer" value="{{ $answer->id }}">
                                    <button type="submit">Post Comment</button>
                                </form>
                        </article>
                    @endcan
                </div>
            </div>
        @endforeach
    </section>
</main>
@endsection