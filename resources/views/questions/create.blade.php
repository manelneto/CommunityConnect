@extends('layouts.app-cc')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.main-navigation-list')
@include('layouts.right')

@section('content')
    @yield('header')
    <main>
        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
        <section id="create-question">
            <h1>Ask a Question</h1>
            <form action="{{ route('questions') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" class="form-control" type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" class="form-control" name="content"  placeholder="Describe your question" required></textarea>
                </div>
                <input id="id_user" type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                <input id="id_community" type="hidden" name="id_community" value="1">
                <button type="submit">Submit</button>
            </form>
        </section>
        @yield('right')
    </main>
    @yield('footer')
@endsection