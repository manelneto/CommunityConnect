@extends('layouts.app')

@section('main')
<main id="communities">
    <section id="communities-header">
        <h2>Communities</h2>
        <header>
            <svg id="svg-communities" width="35" height="25" viewBox="0 0 52 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M34.0357 30.5715C36.1068 30.5715 37.7857 32.2505 37.7857 34.3215V38.6115L37.7688 38.8439C37.1029 43.4001 33.0104 45.5909 26.1431 45.5909C19.3006 45.5909 15.1428 43.4251 14.2453 38.9213L14.2143 38.6072V34.3215C14.2143 32.2505 15.8932 30.5715 17.9643 30.5715H34.0357ZM35.0941 17.7142L47.9643 17.7144C50.0353 17.7144 51.7143 19.3933 51.7143 21.4644V25.7543L51.6974 25.9868C51.0315 30.5429 46.939 32.7338 40.0717 32.7338L39.7112 32.7303C39.05 30.3669 36.9522 28.6035 34.4189 28.4409L34.0357 28.4287L32.0595 28.4302C34.2452 26.6624 35.6428 23.9588 35.6428 20.9287C35.6428 19.8016 35.4495 18.7196 35.0941 17.7142ZM4.03571 17.7144L16.9059 17.7142C16.5505 18.7196 16.3571 19.8016 16.3571 20.9287C16.3571 23.7805 17.5952 26.3432 19.5631 28.1087L19.9405 28.4302L17.9643 28.4287C15.2596 28.4287 12.9804 30.2509 12.2876 32.7346L12.2145 32.7338C5.37202 32.7338 1.21421 30.568 0.316697 26.0642L0.285706 25.7501V21.4644C0.285706 19.3933 1.96464 17.7144 4.03571 17.7144ZM26 13.4287C30.1421 13.4287 33.5 16.7865 33.5 20.9287C33.5 25.0708 30.1421 28.4287 26 28.4287C21.8579 28.4287 18.5 25.0708 18.5 20.9287C18.5 16.7865 21.8579 13.4287 26 13.4287ZM39.9286 0.571533C44.0707 0.571533 47.4286 3.9294 47.4286 8.07153C47.4286 12.2137 44.0707 15.5715 39.9286 15.5715C35.7864 15.5715 32.4286 12.2137 32.4286 8.07153C32.4286 3.9294 35.7864 0.571533 39.9286 0.571533ZM12.0714 0.571533C16.2136 0.571533 19.5714 3.9294 19.5714 8.07153C19.5714 12.2137 16.2136 15.5715 12.0714 15.5715C7.92928 15.5715 4.57142 12.2137 4.57142 8.07153C4.57142 3.9294 7.92928 0.571533 12.0714 0.571533Z" fill="black" />
            </svg>
            <section class="add-tooltip">
                <h2>Communities</h2>
                <div class="tooltip-icon">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">Here are all the existing Communities listed. Clicking on their name will take you to their page and show you all the questions posted to each one. You can press the <b>Follow</b> button for those questions to appear on your <i>Personal Feed</i>.</p>
                </div>
            </section>
        </header>
        <p id="title">Join a community to start asking questions and sharing knowledge.</p>
    </section>
    <section id="communities-listing">
        <h3>Communities</h3>
        @foreach ($communities as $community)
            @include('partials.community', ['community' => $community])
        @endforeach
    </section>
</main>
@endsection
