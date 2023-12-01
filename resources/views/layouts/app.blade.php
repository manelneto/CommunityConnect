@include ('layouts.aside')
@include ('layouts.footer')
@include ('layouts.header')
@include ('layouts.nav')


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app-cc.css') }}" rel="stylesheet">
        <link href="{{ asset('css/login-page.css') }}" rel="stylesheet">
        <link href="{{ asset('css/register-page.css') }}" rel="stylesheet">
        <link href="{{ asset('css/questions-listing.css') }}" rel="stylesheet">
        <link href="{{ asset('css/question-page.css') }}" rel="stylesheet">
        <link href="{{ asset('css/edit-questions-page.css') }}" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
        <link href="{{ asset('css/error.css') }}" rel="stylesheet">
        <link href="{{ asset('css/edit-profile.css') }}" rel="stylesheet">
        <link href="{{ asset('css/profile-page.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ask-question.css') }}" rel="stylesheet">
        <link href="{{ asset('css/about-us-page.css') }}" rel="stylesheet">

        <!-- JavaScript -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/side-bar-responsive.js') }}" defer></script>
        <script src="{{ asset('js/password.js') }}" defer></script>
        <script src="{{ asset('js/profile.js') }} " defer></script>
        <script src="{{ asset('js/findUser.js') }} " defer></script>
        <script src="{{ asset('js/questions-filters.js') }} " defer></script>
        <script src="{{ asset('js/search-bar.js') }} " defer></script>
    </head>

    <body>
        <header class="website-header">
            @yield('header')
        </header>
        @if (Request::route()->getName() == 'login' || Request::route()->getName() == 'register') <!-- TODO -->
            @yield('main')
        @else
        <div id="page-info">
        <nav class="menu-nav">
            @yield('nav')
        </nav>
        <nav class="mobile-aside-bar hidden">
            <svg class="close-mobile-bar" width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.50568 1.23613C0.529356 2.21246 0.529356 3.79536 1.50568 4.77168L10.4685 13.7345L1.50568 22.6975C0.529356 23.6737 0.529356 25.2567 1.50568 26.233C2.48198 27.2092 4.06491 27.2092 5.04121 26.233L14.004 17.27L22.967 26.233C23.9433 27.2092 25.5263 27.2092 26.5025 26.233C27.4788 25.2567 27.4788 23.6737 26.5025 22.6975L17.5395 13.7345L26.5025 4.77171C27.4788 3.79541 27.4788 2.21248 26.5025 1.23618C25.526 0.259856 23.9433 0.259856 22.967 1.23618L14.004 10.199L5.04121 1.23613C4.06491 0.259831 2.48198 0.259831 1.50568 1.23613Z" fill="#636569" />
            </svg>
            @yield('nav')
        </nav>
        @yield('main')
        <aside class="right-bar">
            @yield('aside')
        </aside>
        </div>
        @endif
        <footer class="main-footer">
            @yield('footer')
        </footer>
    </body>
</html>
