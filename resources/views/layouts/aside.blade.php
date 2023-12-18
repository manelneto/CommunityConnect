@section ('aside')
        @can('create', App\Models\Question::class)
            <a class="ask-a-question-button" href="{{ route('create-question') }}">Ask a Question</a><!-- TODO -->
        @endauth
        <section class="right-bar-stats">
            <article class="left-top-square">
                <h3 class="square-text">Questions</h3>
                <p class="square-number">6</p>
            </article>
            <article class="right-top-square">
                <h3 class="square-text">Answers</h3>
                <p class="square-number">12</p>
            </article>
            <article class="left-bottom-square">
                <h3 class="square-text">Solved</h3>
                <p class="square-number">4</p>
            </article>
            <article class="right-bottom-square">
                <h3 class="square-text">Users</h3>
                <p class="square-number">150</p>
            </article>
        </section>
        <section class="right-bar-popular-questions">
            <h2 class="popular-communities-text">
                <svg width="24" height="24" viewBox="0 0 52 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M34.0357 30.5715C36.1068 30.5715 37.7857 32.2505 37.7857 34.3215V38.6115L37.7688 38.8439C37.1029 43.4001 33.0104 45.5909 26.1431 45.5909C19.3006 45.5909 15.1428 43.4251 14.2453 38.9213L14.2143 38.6072V34.3215C14.2143 32.2505 15.8932 30.5715 17.9643 30.5715H34.0357ZM35.0941 17.7142L47.9643 17.7144C50.0353 17.7144 51.7143 19.3933 51.7143 21.4644V25.7543L51.6974 25.9868C51.0315 30.5429 46.939 32.7338 40.0717 32.7338L39.7112 32.7303C39.05 30.3669 36.9522 28.6035 34.4189 28.4409L34.0357 28.4287L32.0595 28.4302C34.2452 26.6624 35.6428 23.9588 35.6428 20.9287C35.6428 19.8016 35.4495 18.7196 35.0941 17.7142ZM4.03571 17.7144L16.9059 17.7142C16.5505 18.7196 16.3571 19.8016 16.3571 20.9287C16.3571 23.7805 17.5952 26.3432 19.5631 28.1087L19.9405 28.4302L17.9643 28.4287C15.2596 28.4287 12.9804 30.2509 12.2876 32.7346L12.2145 32.7338C5.37202 32.7338 1.21421 30.568 0.316697 26.0642L0.285706 25.7501V21.4644C0.285706 19.3933 1.96464 17.7144 4.03571 17.7144ZM26 13.4287C30.1421 13.4287 33.5 16.7865 33.5 20.9287C33.5 25.0708 30.1421 28.4287 26 28.4287C21.8579 28.4287 18.5 25.0708 18.5 20.9287C18.5 16.7865 21.8579 13.4287 26 13.4287ZM39.9286 0.571533C44.0707 0.571533 47.4286 3.9294 47.4286 8.07153C47.4286 12.2137 44.0707 15.5715 39.9286 15.5715C35.7864 15.5715 32.4286 12.2137 32.4286 8.07153C32.4286 3.9294 35.7864 0.571533 39.9286 0.571533ZM12.0714 0.571533C16.2136 0.571533 19.5714 3.9294 19.5714 8.07153C19.5714 12.2137 16.2136 15.5715 12.0714 15.5715C7.92928 15.5715 4.57142 12.2137 4.57142 8.07153C4.57142 3.9294 7.92928 0.571533 12.0714 0.571533Z" fill="black" />
                </svg>
                Popular Communities
            </h2>
            <div class="popular-communities">
                @foreach($popularCommunities as $community)
                    <article class="right-bar-popular">
                        <div class="right-bar-name-and-badge">
                            @if ($loop->iteration <= 3)
                                <svg class="right-bar-medal-svg" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.5 7.66667L4.75 1H1L5.22419 8.88517M8.5 7.66667L12.25 1H16L11.7758 8.88517M8.5 7.66667C9.76 7.66667 10.9232 8.13625 11.7758 8.88517M8.5 7.66667C7.24 7.66667 6.07673 8.13625 5.22419 8.88517M5.22419 8.88517C4.35793 9.64608 3.8125 10.6953 3.8125 11.8333C3.8125 14.1345 5.91117 16 8.5 16C11.0888 16 13.1875 14.1345 13.1875 11.8333C13.1875 10.6953 12.6421 9.64608 11.7758 8.88517" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            @endif
                            <p class="right-bar-name"> {{$community->name}} </p>
                        </div>
                        <p class="right-bar-count"> {{$community->users_count}} followers </p>
                    </article>
                @endforeach
            </div>
        </section>
        <section class="right-bar-top-members">
            <h2 class="top-members-text">
                <svg width="24" height="24" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M84.5 72.3957L77.2972 74.0982C75.682 74.491 74.416 75.7133 74.0668 77.3285L72.5389 83.7457C71.7095 87.238 67.2568 88.3293 64.9431 85.5791L51.8906 70.5622C50.843 69.3399 51.4104 67.4191 52.982 67.0262C60.7087 65.1491 67.6497 60.8274 72.7572 54.6722C73.5866 53.6682 75.0708 53.5372 75.9875 54.4539L85.6787 64.1451C88.9964 67.4628 87.8177 71.6099 84.5 72.3957Z" fill="#272930" />
                    <path d="M3.51756 72.3957L10.7204 74.0982C12.3356 74.491 13.6016 75.7133 13.9508 77.3285L15.4787 83.7457C16.3081 87.238 20.7608 88.3293 23.0745 85.5791L36.127 70.5622C37.1747 69.3399 36.6072 67.4191 35.0356 67.0262C27.3089 65.1491 20.3679 60.8274 15.2604 54.6722C14.431 53.6682 12.9468 53.5372 12.0301 54.4539L2.33891 64.1451C-0.978777 67.4628 0.199875 71.6099 3.51756 72.3957Z" fill="#272930" />
                    <path d="M44.1192 0.497437C27.2252 0.497437 13.5615 14.1611 13.5615 31.0551C13.5615 37.3849 15.4386 43.1909 18.669 48.0364C23.3836 55.021 30.8484 59.9539 39.5355 61.2199C41.0198 61.4818 42.5477 61.6128 44.1192 61.6128C45.6907 61.6128 47.2186 61.4818 48.7028 61.2199C57.3899 59.9539 64.8547 55.021 69.5694 48.0364C72.7997 43.1909 74.6769 37.3849 74.6769 31.0551C74.6769 14.1611 61.0132 0.497437 44.1192 0.497437ZM57.4773 30.0947L53.854 33.718C53.2428 34.3291 52.8936 35.5078 53.1119 36.3809L54.1596 40.8772C54.989 44.4132 53.1119 45.8101 49.9688 43.933L45.6034 41.3574C44.8177 40.8772 43.508 40.8772 42.7223 41.3574L38.3569 43.933C35.2138 45.7664 33.3367 44.4132 34.1661 40.8772L35.2138 36.3809C35.3884 35.5514 35.0829 34.3291 34.4717 33.718L30.7611 30.0947C28.6221 27.9557 29.3205 25.8166 32.289 25.3365L36.96 24.5507C37.7457 24.4197 38.6625 23.7213 39.0117 23.0228L41.5873 17.8717C42.9842 15.0778 45.2542 15.0778 46.6511 17.8717L49.2267 23.0228C49.5759 23.7213 50.4926 24.4197 51.3221 24.5507L55.993 25.3365C58.9178 25.8166 59.6163 27.9557 57.4773 30.0947Z" fill="#272930" />
                </svg>
                Top Members
            </h2>
            <article class="top-member">
                <img class="top-member-pfp member-pfp" src="{{ asset('profile/default.png') }}" alt="User's profile picture" />
                <h3><a href="#" class="top-member-username">matildesimoes</a></h3>
                <p class="top-member-score">120 score</p>
            </article>
            <article class="top-member">
                <img class="top-member-pfp member-pfp" src="{{ asset('profile/default.png') }}" alt="User's profile picture" />
                <h3><a href="#" class="top-member-username">matildesimoes</a></h3>
                <p class="top-member-score">120 score</p>
            </article>
            <article class="top-member">
                <img class="top-member-pfp member-pfp" src="{{ asset('profile/default.png') }}" alt="User's profile picture" />
                <h3><a href="#" class="top-member-username">matildesimoes</a></h3>
                <p class="top-member-score">120 score</p>
            </article>
        </section>
@endsection
