@extends('layouts.app')

@section('main')
    <header class="main-features-title">
        <h1>Main Features<h1>
    </header>
    <section class="main-features-content">
        <article class="feature-section">
            <h3>If you are an user, you can:</h3>
            <ul>
                <li>View popular questions</li>
                <li>Search questions by exact match search, full-text search, tags, multiple attributes and filters</li>
                <li>View question details</li>
                <li>View profiles</li>
                <li>Form field placeholders, contextual error messages and contextual help</li>
                <li>About and contact us</li>
                <li>View communities</li>
                <li>View ratings</li>
            </ul>
        </article>
        <article class="feature-section">
            <h3>If you are a visitor, you can:</h3>
            <ul>
                <li>Login/logout</li>
                <li>Registration</li>
            </ul>
        </article> 
    </section>
@endsection