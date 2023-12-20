@extends('layouts.app')

@section('main')
    <main id="main-features-page">
        <section id="main-features-content">
            <h1 id="title-main-features">Main Features</h1>
            <details class="feature-section">
                <summary>If you are a user, you can:</summary>
                <ul class="feature">
                    <li>View popular questions</li>
                    <li>Search questions by exact match search, full-text search, tags, multiple attributes and filters</li>
                    <li>View question details</li>
                    <li>View profiles</li>
                    <li>Have form field placeholders, contextual error messages and contextual help</li>
                    <li>Consult about and contact us</li>
                    <li>View communities</li>
                    <li>View ratings</li>
                </ul>
            </details>
            <details class="feature-section">
                <summary>If you are a visitor, you can:</summary>
                <ul class="feature">
                    <li>Login</li>
                    <li>Register</li>
                </ul>
            </details>
            <details class="feature-section">
                <summary>If you are an authenticated user, you can:</summary>
                <ul class="feature">
                    <li>View personal feed</li>
                    <li>Post questions and answers</li>
                    <li>View your own questions and answers</li>
                    <li>Logout</li>
                    <li>View and edit your profile</li>
                    <li>Like/dislike questions and answers</li>
                    <li>Comment on questions and answers</li>
                    <li>Mark interest in questions and tags</li>
                    <li>View and receive notifications of answers, comments, likes/dislikes and badges</li>
                    <li>Recover your password</li>
                    <li>Delete your own account</li>
                    <li>Have a profile picture</li>
                    <li>View personal notifications</li>
                    <li>Receive badges</li>
                    <li>Become an expert</li>
                    <li>Attach files</li>
                    <li>Have a rating</li>
                    <li>Follow a community</li>
                </ul>
            </details>
            <details class="feature-section">
                <summary>If you are the author of a question, you can:</summary>
                <ul class="feature">
                    <li>Edit the question</li>
                    <li>Delete the question</li>
                    <li>Edit the tags of the question</li>
                    <li>Mark answers as correct</li>
                    <li>Remove correct mark from answers</li>
                </ul>
            </details>
            <details class="feature-section">
                <summary>If you are the author of an answer or a comment, you can:</summary>
                <ul class="feature">
                    <li>Edit answers or comments</li>
                    <li>Delete answers or comments</li>
                </ul>
            </details>
            <details class="feature-section">
                <summary>If you are a moderator, you can:</summary>
                <ul class="feature">
                    <li>Delete content</li>
                    <li>Edit tags of questions</li>
                </ul>
            </details>
            <details class="feature-section" id="feature-section-final">
                <summary>If you are an administrator, you can:</summary>
                <ul class="feature">
                    <li>Manage user accounts</li>
                    <li>Manage tags</li>
                    <li>Have an administrator account</li>
                    <li>Block and unblock accounts</li>
                    <li>Delete accounts</li>
                </ul>
            </details>
        </section>
    </main>
@endsection
