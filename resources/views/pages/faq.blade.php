@extends('layouts.app')

@section('main')
    <main id="faq-page">
        <section id="faq">
            <h1 id="faq-title">Frequently Asked Questions</h1>
            <details>
                <summary>What is the purpose of Community Connect?</summary>
                <p class="form-faq">Community Connect is a web-based information system that allows users to share questions and get answers on various topics, aiming to provide solutions to common problems in a collaborative help-oriented environment.</p>
            </details>
            <details>
                <summary>How can I participate?</summary>
                <p class="form-faq">To participate, simply create a free account. Click on the Sign-Up button, fill in the necessary information, and start exploring and interacting with communities.</p>
            </details>
            <details>
                <summary>Can I participate in multiple communities simultaneously?</summary>
                <p class="form-faq">Yes, authenticated users can participate in multiple communities simultaneously. This allows you to create a personalized feed.</p>
            </details>
            <details>
                <summary>How do I ask a question?</summary>
                <p class="form-faq">Click on the "Ask a Question" button. Enter the title, content, and choose the community where you want to post your question.</p>
            </details>
            <details>
                <summary>Can I vote on questions and answers?</summary>
                <p class="form-faq">Yes, the platform encourages interaction from authenticated users by allowing them to like/dislike questions and answers. This helps highlight the most relevant and helpful content.</p>
            </details>
            <details id="last-faq">
                <summary>How is the rating of an authenticated user calculated?</summary>
                <p class="form-faq">Ratings are calculated based on the likes and dislikes received by a user's answers within each community.</p>
            </details>
        </section>
    </main>
@endsection
