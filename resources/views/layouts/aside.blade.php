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
                            <a href="{{ route('community', ['id' => $community->id]) }}" class="right-bar-name"> {{$community->name}} </a>
                        </div>
                        <p class="right-bar-count"> {{$community->users_count}} followers </p>
                    </article>
                @endforeach
            </div>
        </section>
        <section class="right-bar-top-members">
            <h2 class="popular-tags-text">
                <svg width="25" height="20" viewBox="0 0 25 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5725 20H10.2762C5.432 20 3.00986 20 1.50492 18.5355C-1.49012e-07 17.0711 0 14.714 0 10C0 5.28595 -1.49012e-07 2.92894 1.50492 1.46446C3.00986 -1.49012e-07 5.43201 0 10.2762 0H13.5725C16.3567 0 17.749 7.45058e-08 18.9111 0.626788C20.0733 1.25358 20.811 2.40239 22.2867 4.70001L23.1378 6.02501C24.3793 7.958 25 8.9245 25 10C25 11.0755 24.3793 12.042 23.1378 13.975L22.2867 15.3C20.811 17.5976 20.0733 18.7464 18.9111 19.3733C17.749 20 16.3567 20 13.5725 20ZM6.25 3.81779C6.76776 3.81779 7.1875 4.21282 7.1875 4.70014V15.2941C7.1875 15.7814 6.76776 16.1765 6.25 16.1765C5.73224 16.1765 5.3125 15.7814 5.3125 15.2941V4.70014C5.3125 4.21282 5.73224 3.81779 6.25 3.81779Z" fill="black"/>
                </svg>
                Popular tags
            </h2>
            <div class="popular-tags">
                @foreach($popularTags as $tag)
                    <article class="right-bar-popular">
                        <div class="right-bar-name-and-badge">
                            @if ($loop->iteration <= 3)
                                <svg class="right-bar-medal-svg" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.5 7.66667L4.75 1H1L5.22419 8.88517M8.5 7.66667L12.25 1H16L11.7758 8.88517M8.5 7.66667C9.76 7.66667 10.9232 8.13625 11.7758 8.88517M8.5 7.66667C7.24 7.66667 6.07673 8.13625 5.22419 8.88517M5.22419 8.88517C4.35793 9.64608 3.8125 10.6953 3.8125 11.8333C3.8125 14.1345 5.91117 16 8.5 16C11.0888 16 13.1875 14.1345 13.1875 11.8333C13.1875 10.6953 12.6421 9.64608 11.7758 8.88517" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            @endif
                            <a href="/questions?text=%5B{{ $tag->name }}%5D" class="right-bar-name"> {{$tag->name}} </a>
                        </div>
                        <p class="right-bar-count"> {{$tag->questions_count}} questions </p>
                    </article>
                @endforeach
            </div>
        </section>
@endsection
