
@include('partials.question', ['question' => $question])
@foreach ($answers as $answer)
    @include('partials.answer', ['answer' => $answer])
@endforeach