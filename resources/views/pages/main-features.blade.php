@extends('layouts.app')

@section('main')
    <main id="main-features-page">
        <section id="main-features-content">
            <h1 id="title-main-features">Main Features</h1>
            <article class="feature-section">
                <h3>If you are a user, you can:</h3>
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
                    <li>Login</li>
                    <li>Registration</li>
                </ul>
            </article> 
            <article class="feature-section">
                <h3>If you are an authenticated user, you can:</h3>
                <ul> 
                    <li>View personal feed</li>
                    <li>Post questions and answers</li>
                    <li>View own questions and answers</li>
                    <li>Logout</li>
                    <li>View and edit profile</li>
                    <li>Like/dislike questions and answers</li>
                    <li>Comment on questions and answers</li>
                    <li>Mark interest in questions and tags</li>
                    <li>View and receive answer, comments, like/dislike and badge notifications</li>
                    <li>Recover password</li>
                    <li>Delete own account</li>
                    <li>Profile picture</li>
                    <li>View personal notifications</li>
                    <li>Receive badges</li>
                    <li>Become an expert</li>
                    <li>Attach files</li>
                    <li>Have a rating</li>
                    <li>Follow a community</li>
                </ul> 
            </article>
            <article class="feature-section">
                <h3>If you are the author of a question, you can:</h3>
                <ul> 
                    <li>Edit questions</li>
                    <li>Delete questions</li>
                    <li>Edit tags of own questions</li>
                    <li>Mark answers as correct</li>
                    <li>Remove correct mark from answers</li>
                </ul>
            </article>
            <article class="feature-section">
                <h3>If you are the author of an answer or a comment, you can:</h3>
                <ul> 
                    <li>Edit answers or comments</li>
                    <li>Delete answers or comments</li>
                </ul>
            </article>
            <article class="feature-section">
                <h3>If you are a moderator, you can:</h3>
                <ul>
                    <li>Delete content</li>
                    <li>Edit tags of questions</li>
                </ul>
            </article>
            <article class="feature-section" id="feature-section-final">
                <h3>If you are an administrator, you can:</h3>
                <ul> 
                    <li>Manage user accounts</li>
                    <li>Manage tags</li>
                    <li>Have an administrator account</li>
                    <li>Block and unblock accounts</li>
                    <li>Delete accounts</li>
                </ul>
            </article>
        </section>
    </main>
@endsection
