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
    <link href="{{ asset('css/app-cc.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login-page.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register-page.css') }}" rel="stylesheet">
    <link href="{{ asset('css/questions-listing.css') }}" rel="stylesheet">
</head>

<!-- JavaScript -->
<script src="{{ asset('js/side-bar-responsive.js') }}"></script>

<body>
    @yield('content')
</body>

</html>
