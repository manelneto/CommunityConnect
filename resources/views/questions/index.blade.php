@extends('layouts.app')

@section('main')
    <main id="questions-listing">
        <section id="questions-info">
            <h2>Showing</h2>
            <article id="questions-stats">
                <h3>{{ $questions->total }} questions</h3>
                <button id="filters-button">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="16" height="16" viewBox="0 0 256 256" xml:space="preserve">
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                            <path d="M 52.537 80.466 V 45.192 L 84.53 2.999 C 85.464 1.768 84.586 0 83.041 0 H 6.959 C 5.414 0 4.536 1.768 5.47 2.999 l 31.994 42.192 v 43.441 c 0 1.064 1.163 1.719 2.073 1.167 l 11.758 -7.127 C 52.065 82.205 52.537 81.368 52.537 80.466 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: #FFFFFF; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                    </svg>
                    Filter
                </button>
            </article>
            <form id="questions-filters" method="post" hidden>
                <fieldset>
                    <legend>Filter by</legend>
                    <section class="add-tooltip">
                    <label for="after">After</label>
                    <input id="after" type="date" name="after">
                        <label for="before">Before</label>
                        <input id="before" type="date" name="before">
                        <div class="tooltip-icon">
                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 416.979 416.979" xml:space="preserve">
                        <path d="M356.004,61.156c-81.37-81.47-213.377-81.551-294.848-0.182c-81.47,81.371-81.552,213.379-0.181,294.85 c81.369,81.47,213.378,81.551,294.849,0.181C437.293,274.636,437.375,142.626,356.004,61.156z M237.6,340.786 c0,3.217-2.607,5.822-5.822,5.822h-46.576c-3.215,0-5.822-2.605-5.822-5.822V167.885c0-3.217,2.607-5.822,5.822-5.822h46.576 c3.215,0,5.822,2.604,5.822,5.822V340.786z M208.49,137.901c-18.618,0-33.766-15.146-33.766-33.765 c0-18.617,15.147-33.766,33.766-33.766c18.619,0,33.766,15.148,33.766,33.766C242.256,122.755,227.107,137.901,208.49,137.901z" />
                    </svg>
                    <p class="tooltip-text">
                        Filter for questions posted <i>after</i> the specified <b>after</b> date, and <i>before</i> the specified <b>before</b> date.
                    </p>
                    </div>
                    </section>
                </fieldset>
                <fieldset>
                    <legend>Sort by</legend>
                    <label for="sort-popular">Popular</label>
                    <input id="sort-popular" type="radio" name="sort" value="popular" checked>
                    <label for="sort-recent">Recent</label>
                    <input id="sort-recent" type="radio" name="sort" value="recent">
                </fieldset>
                <div id="filters-buttons">
                    <button id="apply-button" type="submit">Apply</button>
                    <button id="reset-filters-button" type="reset">Reset Filters</button>
                </div>
            </form>
        </section>
        <section id="questions">
            <h1>Questions</h1>
            @foreach ($questions->data as $question)
                @include('partials.question', ['question' => $question])
            @endforeach
        </section>
    </main>
@endsection
