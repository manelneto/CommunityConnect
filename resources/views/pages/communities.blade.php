@extends('layouts.app')

@section('main')
    <main id="communities">
        <section>
            <h1>Communities</h1>
            <p id="title">Join a community to start asking questions and sharing knowledge.</p>
            <div id="communities-listing">
                @foreach ($communities as $community)
                    @include('partials.community', ['community' => $community])
                @endforeach
            </div>
        </section>
    </main>
@endsection