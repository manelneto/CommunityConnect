<article class="community">
    <svg width="135" height="135" viewBox="0 0 135 135" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M128.324 40.4316C131.009 44.2548 127.808 48.9221 123.137 48.9221H6.74787C3.02116 48.9221 0 45.9009 0 42.1742V29.8256C0 13.3608 13.3608 0 29.8256 0H45.4807C56.4797 0 59.9211 3.57637 64.3072 9.44702L73.7542 21.9981C75.8461 24.7647 76.116 25.1021 80.0298 25.1021H98.8563C111.034 25.1021 121.81 31.1555 128.324 40.4316Z" />
        <path d="M128.098 59.0439C131.815 59.0439 134.833 62.0514 134.845 65.7688L134.957 98.8584C134.957 118.765 118.763 134.959 98.8563 134.959H36.1011C16.1949 134.959 0 118.765 0 98.8584V65.7938C0 62.0669 3.02109 59.0459 6.74781 59.0459L128.098 59.0439Z" />
    </svg>
    <h2><a href="communities/{{ $community->id }}">{{ $community->name }}</a></h2>
    @auth
        @if (Auth::user()->communities->contains($community->id))
        <button id="{{ $community->id }}" class="unfollow-community">Unfollow</button>
        @else
        <button id="{{ $community->id }}" class="follow-community">Follow</button>
        @endif
    @endauth
    <p>{{ $community->users_count }} Followers</p>
</article>
