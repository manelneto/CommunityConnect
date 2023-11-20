<div class="question-container">
    <img class="member-pfp question-member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
         alt="User's profule picture" />
    <div class="content-right">
        <div class="question-details">
            <a href="../users/{{ $question->id_user }}" class="question-username">{{ $question->user->username }}</a>
            <span class="question-asked-date">Asked: {{ $question->date }}</span>
            <span class="question-community">In: {{ $question->community->name }}</span>
        </div>
        <h2 class="question-title">{{ $question->title }}</h2>
        <p class="question-description">{{ $question->content }}</p>
        <div class="answers-details">
            <button class="question-answer-btn">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z"
                            fill="#abacb1" />
                </svg>{{ $question->answers_count }} Answers</button>
            <span class="question-upvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z" fill="#38B6FF" />
                </svg>
                {{ $question->likes_count }}</span>
            <span class="question-downvotes">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z" fill="#ABACB1" />
                </svg>
                {{ $question->dislikes_count }}</span>
        </div>
    </div>
    @foreach ($answers as $answer)
        @include('partials.answer', ['answer' => $answer])
    @endforeach
    @if ($errors->any())
        <div class="error-box">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    @auth
    <form action="/answers" method="POST">
        @csrf
        <label for="content">Your Answer:</label>
        <textarea id="content" name="content" rows="4" cols="50"></textarea>
        <br>
        <input type="hidden" name="id_question" value="{{ $question->id }}">
        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
        <input type="submit" value="Post Answer">
    </form>
    @endauth
</div>
