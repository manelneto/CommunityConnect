<article class="community">
    <div class="community-interaction">
        <h2><a href="communities/{{ $community->id }}">{{ $community->name }}</a></h2>
        @auth
            @if (Auth::user()->communities->contains($community->id))
            <button id="{{ $community->id }}" class="unfollow-community">Unfollow</button>
            @else
            <button id="{{ $community->id }}" class="follow-community">Follow</button>
            @endif
        @endauth
    </div>
    <p>{{ $community->users_count }} Followers</p>
</article>
