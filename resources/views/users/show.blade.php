@extends('layouts.app')

@section('main')
    <main id="profile-info">
        <section id="edit-profile-a">
            <h1>{{ $user->username }} @if ($user->blocked) (blocked) @endif</h1>
            <div id="profile-buttons">
                @if (Auth::user()?->id === $user->id)
                    <img class="notifications-icon" src="{{ asset('assets/notifications.png') }}" alt="Notifications icon"/>
                    <p class="notifications-number">{{ count($unread) }}</p>
                    <ul class="notifications">
                        @foreach ($notifications as $notification)
                        <li class="profile-notification">
                            <p class="notification-text">{{ $notification->content }}</p>
                            <p class="notification-date">{{ $notification->date->format('Y-m-d') }}</p>
                            @if (!$notification->read)
                                <p class="read-not-tooltip">Mark as read</p>
                                <img id="{{ $notification->id }}" class="view-icon" src="{{ asset('assets/view.png') }}" alt="View icon"/>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @endif
                @can ('edit', $user)
                    <a class="edit-profile" href="{{ route('edit-user', ['id' => $user->id]) }}">Edit</a>
                @endcan
                @can ('destroy', $user)
                    <form action="{{ route('delete-user', ['id' => $user->id]) }}" method="post">
                        @csrf
                        <button id="delete-account" type="submit"> Delete account </button>
                    </form>
                @endcan
            </div>
        </section>
        <h2 class="profile-email">{{ $user->email }}</h2>
        <img class="member-pfp main-user-pfp" src="{{ asset($user->image) }}" alt="User's profile photo" />
        <ul>
            <li class="profile" id="about-button">About</li>
            <li class="profile" id="questions-button">Questions</li>
            <li class="profile" id="answers-button">Answers</li>
        </ul>
        <section class="about-user">
            <h3 class="user-register-date">Member since {{ $user->register_date->format('Y-m-d') }}</h3>
            @if (count($user->badges) > 0)
                <ul class="user-badges">
                    @foreach ($user->badges as $badge)
                        <li class="profile user-received-badge">
                            <img src="{{ asset('assets/badge-images') . '/badge_' . $badge->id . '.png' }}" alt="Badge">
                        </li>
                    @endforeach
                </ul>
            @endif
            <ul class="user-stats">
                <li class="profile user-stats-questions">
                    <svg width="40" height="40" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6776 5.27878C13.6534 5.5454 12.5815 6.0331 11.818 6.7811C11.0545 7.52913 10.5567 8.5793 10.2846 10.5625C10.0044 12.604 10 15.3097 10 19.1892V40.6105C10.9717 39.9452 12.0668 39.439 13.2475 39.1293C14.5679 38.7825 16.1076 38.783 18.3641 38.7838H50V19.1892C50 15.3097 49.9955 12.604 49.7155 10.5625C49.4432 8.5793 48.9455 7.52913 48.182 6.7811C47.4185 6.0331 46.3468 5.5454 44.3225 5.27878C42.2388 5.0043 39.477 5 35.5172 5H24.4828C20.523 5 17.7613 5.0043 15.6776 5.27878ZM16.8965 16.4865C16.8965 15.367 17.8228 14.4595 18.9655 14.4595H41.0345C42.1772 14.4595 43.1035 15.367 43.1035 16.4865C43.1035 17.606 42.1772 18.5135 41.0345 18.5135H18.9655C17.8228 18.5135 16.8965 17.606 16.8965 16.4865ZM18.9655 23.9189C17.8228 23.9189 16.8965 24.8264 16.8965 25.946C16.8965 27.0655 17.8228 27.973 18.9655 27.973H32.7585C33.9013 27.973 34.8275 27.0655 34.8275 25.946C34.8275 24.8264 33.9013 23.9189 32.7585 23.9189H18.9655Z" fill="#38B6FF" />
                        <path d="M18.6835 42.8378H21.7241H32.7584H49.9977C49.9889 45.6643 49.9439 47.772 49.7154 49.4375C49.4432 51.4208 48.9454 52.471 48.1819 53.219C47.4184 53.967 46.3467 54.4545 44.3224 54.7213C42.2387 54.9958 39.4769 55 35.5172 55H24.4827C20.5229 55 17.7612 54.9958 15.6775 54.7213C13.6533 54.4545 12.5814 53.967 11.8179 53.219C11.0544 52.471 10.5566 51.4208 10.2845 49.4375C10.1814 48.6865 10.1157 47.8455 10.0737 46.8895C10.7521 45.011 12.3341 43.566 14.3184 43.045C15.0414 42.8553 15.9848 42.8378 18.6835 42.8378Z"                               fill="#38B6FF" />
                    </svg>
                    <div class="user-stats-text user-stats-text-less-margin">
                        <p class="user-stats-count">{{ count($questions) }} </p>
                        <p>Questions</p>
                    </div>
                </li>
                <li class="profile user-stats-answers">
                    <svg width="35" height="35" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M29.072 46.1795L27.7168 48.4692C26.5088 50.51 23.4912 50.51 22.2832 48.4692L20.928 46.1795C19.8768 44.4035 19.3512 43.5158 18.507 43.0245C17.6627 42.5335 16.5998 42.5153 14.4739 42.4788C11.3355 42.4245 9.36722 42.2323 7.71645 41.5485C4.6536 40.2798 2.22017 37.8465 0.9515 34.7835C-7.45058e-08 32.4865 0 29.5742 0 23.75V21.25C0 13.0664 -1.49012e-07 8.97462 1.842 5.96877C2.8727 4.28682 4.28682 2.8727 5.96877 1.842C8.97462 -1.49012e-07 13.0664 0 21.25 0H28.75C36.9335 0 41.0252 -1.49012e-07 44.0312 1.842C45.7132 2.8727 47.1273 4.28682 48.158 5.96877C50 8.97462 50 13.0664 50 21.25V23.75C50 29.5742 50 32.4865 49.0485 34.7835C47.7798 37.8465 45.3465 40.2798 42.2835 41.5485C40.6328 42.2323 38.6645 42.4245 35.526 42.4788C33.4 42.5153 32.3373 42.5335 31.493 43.0245C30.6488 43.5155 30.123 44.4035 29.072 46.1795ZM15 24.375C13.9645 24.375 13.125 25.2145 13.125 26.25C13.125 27.2855 13.9645 28.125 15 28.125H28.75C29.7855 28.125 30.625 27.2855 30.625 26.25C30.625 25.2145 29.7855 24.375 28.75 24.375H15ZM13.125 17.5C13.125 16.4645 13.9645 15.625 15 15.625H35C36.0355 15.625 36.875 16.4645 36.875 17.5C36.875 18.5355 36.0355 19.375 35 19.375H15C13.9645 19.375 13.125 18.5355 13.125 17.5Z" fill="#BD2020" />
                    </svg>
                    <div class="user-stats-text">
                        <p class="user-stats-count">{{ count($answers) }}</p>
                        <p>Answers</p>
                    </div>
                </li>
            </ul>
            <section id="rating-communities">
                <h4>Reputation</h4>
                @foreach ($reputations as $reputation)
                    <article class="card-rating">
                        <svg width="30" height="20" viewBox="0 0 52 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M34.0357 30.5715C36.1068 30.5715 37.7857 32.2505 37.7857 34.3215V38.6115L37.7688 38.8439C37.1029 43.4001 33.0104 45.5909 26.1431 45.5909C19.3006 45.5909 15.1428 43.4251 14.2453 38.9213L14.2143 38.6072V34.3215C14.2143 32.2505 15.8932 30.5715 17.9643 30.5715H34.0357ZM35.0941 17.7142L47.9643 17.7144C50.0353 17.7144 51.7143 19.3933 51.7143 21.4644V25.7543L51.6974 25.9868C51.0315 30.5429 46.939 32.7338 40.0717 32.7338L39.7112 32.7303C39.05 30.3669 36.9522 28.6035 34.4189 28.4409L34.0357 28.4287L32.0595 28.4302C34.2452 26.6624 35.6428 23.9588 35.6428 20.9287C35.6428 19.8016 35.4495 18.7196 35.0941 17.7142ZM4.03571 17.7144L16.9059 17.7142C16.5505 18.7196 16.3571 19.8016 16.3571 20.9287C16.3571 23.7805 17.5952 26.3432 19.5631 28.1087L19.9405 28.4302L17.9643 28.4287C15.2596 28.4287 12.9804 30.2509 12.2876 32.7346L12.2145 32.7338C5.37202 32.7338 1.21421 30.568 0.316697 26.0642L0.285706 25.7501V21.4644C0.285706 19.3933 1.96464 17.7144 4.03571 17.7144ZM26 13.4287C30.1421 13.4287 33.5 16.7865 33.5 20.9287C33.5 25.0708 30.1421 28.4287 26 28.4287C21.8579 28.4287 18.5 25.0708 18.5 20.9287C18.5 16.7865 21.8579 13.4287 26 13.4287ZM39.9286 0.571533C44.0707 0.571533 47.4286 3.9294 47.4286 8.07153C47.4286 12.2137 44.0707 15.5715 39.9286 15.5715C35.7864 15.5715 32.4286 12.2137 32.4286 8.07153C32.4286 3.9294 35.7864 0.571533 39.9286 0.571533ZM12.0714 0.571533C16.2136 0.571533 19.5714 3.9294 19.5714 8.07153C19.5714 12.2137 16.2136 15.5715 12.0714 15.5715C7.92928 15.5715 4.57142 12.2137 4.57142 8.07153C4.57142 3.9294 7.92928 0.571533 12.0714 0.571533Z" fill="black"/>
                        </svg>
                        <h3>{{ $reputation->community->name }}</h3>
                        <img class="rating-stars" src="{{ asset('assets/rating-images/star-rating.png') }}" alt="Rating stars">
                        <p>{{ $reputation->rating }} score</p>
                    </article>
                @endforeach
                @foreach ($moderatorCommunities as $community)
                    <article class="card-moderator-community card-rating">
                        <div class="svg-and-text">
                            <svg width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_378_1879)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M47.5 3.7104e-05L57.5 0C58.163 -2.38415e-06 58.7987 0.263387 59.2677 0.732227C59.7365 1.20106 60 1.83695 60 2.49999V12.5C60 13.1631 59.7365 13.7989 59.2677 14.2678L29.7855 43.75L34.2677 48.2323C35.244 49.2085 35.244 50.7915 34.2677 51.7677C33.2915 52.7442 31.7085 52.7442 30.7323 51.7677L24.4822 45.5177L23.6594 44.695L14.9997 52.4888C15.0024 54.4088 14.2718 56.335 12.8033 57.8035C9.87437 60.7325 5.12562 60.7325 2.1967 57.8035C-0.732233 54.8745 -0.732233 50.1258 2.1967 47.1968C3.66517 45.7283 5.59117 44.9978 7.51127 45.0005L15.305 36.3407L14.4822 35.5177L8.23222 29.2677C7.25592 28.2915 7.25592 26.7085 8.23222 25.7323C9.20855 24.756 10.7914 24.756 11.7678 25.7323L16.2499 30.2145L45.7323 0.732267C46.201 0.26343 46.837 3.9488e-05 47.5 3.7104e-05ZM19.7855 33.75L20.5177 34.4823L25.5177 39.4823L26.25 40.2145L55 11.4645V5L48.5355 5.00003L19.7855 33.75ZM18.8455 39.881L12.5109 46.9195C12.6103 47.0087 12.7078 47.1013 12.8033 47.1968C12.8988 47.2923 12.9912 47.3898 13.0805 47.4893L20.119 41.1545L18.8455 39.881ZM8.0169 50.0535C7.21112 49.885 6.35022 50.1145 5.73222 50.7325C4.75592 51.7087 4.75592 53.2915 5.73222 54.268C6.70855 55.2442 8.29145 55.2442 9.26777 54.268C9.88577 53.65 10.1152 52.789 9.94655 51.9833C9.8508 51.5258 9.62687 51.0915 9.26777 50.7325C8.90865 50.3732 8.47425 50.1493 8.0169 50.0535Z" fill="#43DB1D"/>
                                </g>
                                <defs>
                                    <clipPath>
                                        <rect width="60" height="60" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <p>Moderator</p>
                        </div>
                        <h3>{{ $community->name }}</h3>
                    </article>
                @endforeach
            </section>
        </section>
        <section id="my-questions">
            <h5>My Questions</h5>
            @foreach ($questions as $question)
                @include('partials.question', ['question' => $question])
            @endforeach
        </section>
        <section id="my-answers">
            <h5>My Answers</h5>
            @foreach ($answers as $answer)
                @include('partials.answer', ['answer' => $answer])
            @endforeach
        </section>
    </main>
@endsection
