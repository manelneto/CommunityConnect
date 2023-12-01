@extends('layouts.app')

@section('main')
    <main>
        <div class="main-content">
            <section id="profile-info">
                <span id="edit-profile-a">
                    <h1>{{ $user->username }}</h1>
                    @if (Auth::user()?->id === $user->id || Auth::user()?->administrator)
                        <a class="edit-profile" href="{{ route('edit-user', $user->id) }}">Edit</a>
                    @endif
                </span>
                <h2>{{ $user->email }}</h2>
                <img class="member-pfp main-user-pfp" src="{{ asset('assets/profile-images/test-profile-image.jpeg') }}" alt="User's profile picture" />
                <ul>
                    <li id="about-button">About</li>
                    <li id="questions-button">Questions</li>
                    <li id="answers-button">Answers</li>
                </ul>
                <section class="about-user">
                    <p class="user-register-date">
                        Member since {{ $user->register_date->format('Y-m-d') }}
                    </p>
                    @if (count($user->badges) > 0)
                        <ul class="user-badges">
                            @foreach ($user->badges as $badge)
                                <li class="user-received-badge">
                                    <img src="{{ asset('assets/badge-images') . '/badge_' . $badge->id . '.png' }}"
                                         alt="badge image">
                                </li>
                            @endforeach
                            @endif
                        </ul>
                        <ul class="user-stats">
                            <li class="user-stats-questions">
                                <svg width="40" height="40" viewBox="0 0 60 60" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M15.6776 5.27878C13.6534 5.5454 12.5815 6.0331 11.818 6.7811C11.0545 7.52913 10.5567 8.5793 10.2846 10.5625C10.0044 12.604 10 15.3097 10 19.1892V40.6105C10.9717 39.9452 12.0668 39.439 13.2475 39.1293C14.5679 38.7825 16.1076 38.783 18.3641 38.7838H50V19.1892C50 15.3097 49.9955 12.604 49.7155 10.5625C49.4432 8.5793 48.9455 7.52913 48.182 6.7811C47.4185 6.0331 46.3468 5.5454 44.3225 5.27878C42.2388 5.0043 39.477 5 35.5172 5H24.4828C20.523 5 17.7613 5.0043 15.6776 5.27878ZM16.8965 16.4865C16.8965 15.367 17.8228 14.4595 18.9655 14.4595H41.0345C42.1772 14.4595 43.1035 15.367 43.1035 16.4865C43.1035 17.606 42.1772 18.5135 41.0345 18.5135H18.9655C17.8228 18.5135 16.8965 17.606 16.8965 16.4865ZM18.9655 23.9189C17.8228 23.9189 16.8965 24.8264 16.8965 25.946C16.8965 27.0655 17.8228 27.973 18.9655 27.973H32.7585C33.9013 27.973 34.8275 27.0655 34.8275 25.946C34.8275 24.8264 33.9013 23.9189 32.7585 23.9189H18.9655Z"
                                          fill="#38B6FF" />
                                    <path
                                            d="M18.6835 42.8378H21.7241H32.7584H49.9977C49.9889 45.6643 49.9439 47.772 49.7154 49.4375C49.4432 51.4208 48.9454 52.471 48.1819 53.219C47.4184 53.967 46.3467 54.4545 44.3224 54.7213C42.2387 54.9958 39.4769 55 35.5172 55H24.4827C20.5229 55 17.7612 54.9958 15.6775 54.7213C13.6533 54.4545 12.5814 53.967 11.8179 53.219C11.0544 52.471 10.5566 51.4208 10.2845 49.4375C10.1814 48.6865 10.1157 47.8455 10.0737 46.8895C10.7521 45.011 12.3341 43.566 14.3184 43.045C15.0414 42.8553 15.9848 42.8378 18.6835 42.8378Z"
                                            fill="#38B6FF" />
                                </svg>
                                <span class="user-stats-text user-stats-text-less-margin"> <span
                                            class="user-stats-count">{{ count($questions) }} </span>
                                <br>
                                Questions</span>
                            </li>
                            <li class="user-stats-answers">
                                <svg width="35" height="35" viewBox="0 0 50 50" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M29.072 46.1795L27.7168 48.4692C26.5088 50.51 23.4912 50.51 22.2832 48.4692L20.928 46.1795C19.8768 44.4035 19.3512 43.5158 18.507 43.0245C17.6627 42.5335 16.5998 42.5153 14.4739 42.4788C11.3355 42.4245 9.36722 42.2323 7.71645 41.5485C4.6536 40.2798 2.22017 37.8465 0.9515 34.7835C-7.45058e-08 32.4865 0 29.5742 0 23.75V21.25C0 13.0664 -1.49012e-07 8.97462 1.842 5.96877C2.8727 4.28682 4.28682 2.8727 5.96877 1.842C8.97462 -1.49012e-07 13.0664 0 21.25 0H28.75C36.9335 0 41.0252 -1.49012e-07 44.0312 1.842C45.7132 2.8727 47.1273 4.28682 48.158 5.96877C50 8.97462 50 13.0664 50 21.25V23.75C50 29.5742 50 32.4865 49.0485 34.7835C47.7798 37.8465 45.3465 40.2798 42.2835 41.5485C40.6328 42.2323 38.6645 42.4245 35.526 42.4788C33.4 42.5153 32.3373 42.5335 31.493 43.0245C30.6488 43.5155 30.123 44.4035 29.072 46.1795ZM15 24.375C13.9645 24.375 13.125 25.2145 13.125 26.25C13.125 27.2855 13.9645 28.125 15 28.125H28.75C29.7855 28.125 30.625 27.2855 30.625 26.25C30.625 25.2145 29.7855 24.375 28.75 24.375H15ZM13.125 17.5C13.125 16.4645 13.9645 15.625 15 15.625H35C36.0355 15.625 36.875 16.4645 36.875 17.5C36.875 18.5355 36.0355 19.375 35 19.375H15C13.9645 19.375 13.125 18.5355 13.125 17.5Z"
                                          fill="#BD2020" />
                                </svg>

                                <span class="user-stats-text"> <span class="user-stats-count">{{ count($answers) }} </span> <br>
                                Answers</span>
                            </li>
                        </ul>
                </section>
                <section id="my-questions">
                    @foreach ($questions as $question)
                        @include('partials.question', ['question' => $question])
                    @endforeach
                </section>
                <section id="my-answers">
                    @foreach ($answers as $answer)
                        @include('partials.answer', ['answer' => $answer])
                    @endforeach
                </section>
            </section>
        </div>
    </main>
@endsection
