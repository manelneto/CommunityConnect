@section('question')

<div class="question-container">
  <img class="member-pfp question-member-pfp" src="./images/random-profile-picture.jpeg" alt="User's profule picture" />
  <div class="content-right">
    <div class="question-details">
      <a href="#" class="question-username">{username}</a>
      <span class="question-asked-date">Asked: {asked_date}</span>
      <span class="question-community">In: {community}</span>
    </div>
    <h2 class="question-title">What's the most bizarre coincidence you've ever experienced?</h2>
    <p class="question-description">Share your mind-blowing stories of improbable coincidences that left you questioning
      the laws of probability.
      Whether it's running into a long-lost friend on the other side of the world or predicting an event moments...</p>
    <div class="answers-details">
      <button class="question-answer-btn">4 Answers</button>
      <span class="question-upvotes">10</span>
      <span class="question-downvotes">2</span>
    </div>
  </div>
</div>

@endsection