@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')

@section('content')
    @yield('header')

    <main>
        <div class="main-content">
            <nav class="menu-nav">
                @yield('main-navigation-list')
            </nav>

            <nav class="mobile-aside-bar hidden">
                <svg class="close-mobile-bar" width="28" height="27" viewBox="0 0 28 27" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.50568 1.23613C0.529356 2.21246 0.529356 3.79536 1.50568 4.77168L10.4685 13.7345L1.50568 22.6975C0.529356 23.6737 0.529356 25.2567 1.50568 26.233C2.48198 27.2092 4.06491 27.2092 5.04121 26.233L14.004 17.27L22.967 26.233C23.9433 27.2092 25.5263 27.2092 26.5025 26.233C27.4788 25.2567 27.4788 23.6737 26.5025 22.6975L17.5395 13.7345L26.5025 4.77171C27.4788 3.79541 27.4788 2.21248 26.5025 1.23618C25.526 0.259856 23.9433 0.259856 22.967 1.23618L14.004 10.199L5.04121 1.23613C4.06491 0.259831 2.48198 0.259831 1.50568 1.23613Z"
                        fill="#636569" />
                </svg>

                @yield('main-navigation-list')

            </nav>

            <section class="main-info">

                <div class="questions-info">
                    <span class="showing-text">Showing</span>
                    <div class="questions-stats">
                        <span class="questions-number">{{ $questions->count() }} questions</span>
                        <button class="filters-button"><svg xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="16" height="16"
                                viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                    transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                    <path
                                        d="M 52.537 80.466 V 45.192 L 84.53 2.999 C 85.464 1.768 84.586 0 83.041 0 H 6.959 C 5.414 0 4.536 1.768 5.47 2.999 l 31.994 42.192 v 43.441 c 0 1.064 1.163 1.719 2.073 1.167 l 11.758 -7.127 C 52.065 82.205 52.537 81.368 52.537 80.466 z"
                                        style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: #FFFFFF; fill-rule: nonzero; opacity: 1;"
                                        transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                </g>
                            </svg>Filter</button>
                    </div>
                    <div class="questions-filters">
                        <form action="#" method="POST">
                            <fieldset>
                                <legend>Filter by</legend>
                                <label for="no-answers">
                                    <input type="checkbox" id="no-answers" name="filter" value="no-answers">
                                    No answers
                                </label>
                                <label for="no-accepted-answer">
                                    <input type="checkbox" id="no-accepted-answer" name="filter"
                                        value="no-accepted-answer">
                                    No accepted answer
                                </label>
                            </fieldset>

                            <fieldset>
                                <legend>Sort by</legend>
                                <label for="most-popular">
                                    <input type="radio" id="most-popular" name="sort" value="most-popular" checked>
                                    Most Popular
                                </label>
                                <label for="newest">
                                    <input type="radio" id="newest" name="sort" value="newest" checked>
                                    Newest
                                </label>
                            </fieldset>

                            <div class="buttons">
                                <button type="submit" class="apply-button">Apply</button>
                                <button type="button" class="cancel-button" onclick="closeModal()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                @foreach ($questions as $question)
                    @include('partials.question', ['question' => $question])
                @endforeach

            </section>
            <section class="right-bar">
                <button class="ask-a-question-button">Ask a Question</button>
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
                        <img class="user-profile-picture" src="./images/random-profile-picture.jpeg"
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
                        <img class="user-profile-picture" src="./images/random-profile-picture.jpeg"
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
                        <img class="user-profile-picture" src="./images/random-profile-picture.jpeg"
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
                        <img class="top-member-pfp member-pfp" src="./images/random-profile-picture.jpeg"
                            alt="User's profule picture" />
                        <a href="#" class="top-member-username">matildesimoes</a>
                        <span class="top-member-score">120 score</span>
                    </div>
                    <div class="top-member">
                        <img class="top-member-pfp member-pfp" src="./images/random-profile-picture.jpeg"
                            alt="User's profule picture" />
                        <a href="#" class="top-member-username">matildesimoes</a>
                        <span class="top-member-score">120 score</span>
                    </div>
                    <div class="top-member">
                        <img class="top-member-pfp member-pfp" src="./images/random-profile-picture.jpeg"
                            alt="User's profule picture" />
                        <a href="#" class="top-member-username">matildesimoes</a>
                        <span class="top-member-score">120 score</span>
                    </div>
                </section>
            </section>
        </div>
    </main>
    @yield('footer')
@endsection
