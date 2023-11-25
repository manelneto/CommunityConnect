@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')
@include('layouts.right')

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
                        <span class="questions-number">{{ count($questions) }} questions</span>
                        <button class="filters-button"><svg xmlns="http://wwwF.w3.org/2000/svg"
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
                    <div class="questions-filters" hidden>
                        <form action="#" method="post">
                            <fieldset>
                                <legend>Filter by</legend>

                                <label for="after">After</label>
                                <input id="after" type="date" name="after">

                                <label for="before">Before</label>
                                <input id="before" type="date" name="before">
                            </fieldset>
                            <fieldset>
                                <legend>Sort by</legend>
                                <label for="sort-popular">
                                    <input type="radio" id="sort-popular" name="sort" value="popular" checked> Popular
                                </label>
                                <label for="sort-recent">
                                    <input type="radio" id="sort-recent" name="sort" value="recent"> Recent
                                </label>
                            </fieldset>
                            <div class="filters-buttons">
                                <button id="apply-button" type="submit">Apply</button>
                                <button type="reset" class="reset-filters-button">Reset Filters</button>
                            </div>
                        </form>
                    </div>
                </div>
                <section id="questions">
                    @foreach ($questions as $question)
                        @include('partials.question', ['question' => $question])
                    @endforeach
                </section>

            </section>
            @yield('right')
        </div>
    </main>
    @yield('footer')
@endsection
