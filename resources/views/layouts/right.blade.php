@section ('right')
    <section class="right-bar">
        <button class="ask-a-question-button" onclick="window.location='{{ route('create-question') }}'">Ask a Question</button>
        <section class="right-bar-stats">
            <div class="left-top-square">
                <span class="square-text">Questions</span>
                <span class="square-number">6</span>
            </div>
            <div class="right-top-square">
                <span class="square-text">Answers</span>
                <span class="square-number">12</span>
            </div>
            <div class="left-bottom-square">
                <span class="square-text">Solved</span>
                <span class="square-number">4</span>
            </div>
            <div class="right-bottom-square">
                <span class="square-text">Users</span>
                <span class="square-number">150</span>
            </div>
        </section>
        <section class="right-bar-popular-questions">
                    <span class="popular-questions-text">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z"
                                    fill="#272930" />
                        </svg>Popular Questions
                    </span>
            <div class="popular-question">
                <img class="user-profile-picture" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                     alt="User's profule picture" />
                <a class="question-title" href="#">
                    How do I cook rice without water?
                </a>
                <div class="popular-question-answers">
                    <svg width="12" height="12" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z" />
                    </svg>
                    <span class="popular-question-n-of-answers">6 answers</span>
                </div>
            </div>
            <div class="popular-question">
                <img class="user-profile-picture" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                     alt="User's profule picture" />
                <a class="question-title" href="#">
                    How do I cook rice without water?
                </a>
                <div class="popular-question-answers">
                    <svg width="12" height="12" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z" />
                    </svg>
                    <span class="popular-question-n-of-answers">6 answers</span>
                </div>
            </div>
            <div class="popular-question">
                <img class="user-profile-picture" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                     alt="User's profule picture" />
                <a class="question-title" href="#">
                    How do I cook rice without water?
                </a>
                <div class="popular-question-answers">
                    <svg width="12" height="12" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z" />
                    </svg>
                    <span class="popular-question-n-of-answers">6 answers</span>
                </div>
            </div>
        </section>
        <section class="right-bar-top-members">
                    <span class="top-members-text">
                        <svg width="24" height="24" viewBox="0 0 88 88" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M84.5 72.3957L77.2972 74.0982C75.682 74.491 74.416 75.7133 74.0668 77.3285L72.5389 83.7457C71.7095 87.238 67.2568 88.3293 64.9431 85.5791L51.8906 70.5622C50.843 69.3399 51.4104 67.4191 52.982 67.0262C60.7087 65.1491 67.6497 60.8274 72.7572 54.6722C73.5866 53.6682 75.0708 53.5372 75.9875 54.4539L85.6787 64.1451C88.9964 67.4628 87.8177 71.6099 84.5 72.3957Z"
                                    fill="#272930" />
                            <path
                                    d="M3.51756 72.3957L10.7204 74.0982C12.3356 74.491 13.6016 75.7133 13.9508 77.3285L15.4787 83.7457C16.3081 87.238 20.7608 88.3293 23.0745 85.5791L36.127 70.5622C37.1747 69.3399 36.6072 67.4191 35.0356 67.0262C27.3089 65.1491 20.3679 60.8274 15.2604 54.6722C14.431 53.6682 12.9468 53.5372 12.0301 54.4539L2.33891 64.1451C-0.978777 67.4628 0.199875 71.6099 3.51756 72.3957Z"
                                    fill="#272930" />
                            <path
                                    d="M44.1192 0.497437C27.2252 0.497437 13.5615 14.1611 13.5615 31.0551C13.5615 37.3849 15.4386 43.1909 18.669 48.0364C23.3836 55.021 30.8484 59.9539 39.5355 61.2199C41.0198 61.4818 42.5477 61.6128 44.1192 61.6128C45.6907 61.6128 47.2186 61.4818 48.7028 61.2199C57.3899 59.9539 64.8547 55.021 69.5694 48.0364C72.7997 43.1909 74.6769 37.3849 74.6769 31.0551C74.6769 14.1611 61.0132 0.497437 44.1192 0.497437ZM57.4773 30.0947L53.854 33.718C53.2428 34.3291 52.8936 35.5078 53.1119 36.3809L54.1596 40.8772C54.989 44.4132 53.1119 45.8101 49.9688 43.933L45.6034 41.3574C44.8177 40.8772 43.508 40.8772 42.7223 41.3574L38.3569 43.933C35.2138 45.7664 33.3367 44.4132 34.1661 40.8772L35.2138 36.3809C35.3884 35.5514 35.0829 34.3291 34.4717 33.718L30.7611 30.0947C28.6221 27.9557 29.3205 25.8166 32.289 25.3365L36.96 24.5507C37.7457 24.4197 38.6625 23.7213 39.0117 23.0228L41.5873 17.8717C42.9842 15.0778 45.2542 15.0778 46.6511 17.8717L49.2267 23.0228C49.5759 23.7213 50.4926 24.4197 51.3221 24.5507L55.993 25.3365C58.9178 25.8166 59.6163 27.9557 57.4773 30.0947Z"
                                    fill="#272930" />
                        </svg>
                        Top Members
                    </span>
            <div class="top-member">
                <img class="top-member-pfp member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                     alt="User's profule picture" />
                <a href="#" class="top-member-username">matildesimoes</a>
                <span class="top-member-score">120 score</span>
            </div>
            <div class="top-member">
                <img class="top-member-pfp member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                     alt="User's profule picture" />
                <a href="#" class="top-member-username">matildesimoes</a>
                <span class="top-member-score">120 score</span>
            </div>
            <div class="top-member">
                <img class="top-member-pfp member-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}"
                     alt="User's profule picture" />
                <a href="#" class="top-member-username">matildesimoes</a>
                <span class="top-member-score">120 score</span>
            </div>
        </section>
    </section>
@endsection