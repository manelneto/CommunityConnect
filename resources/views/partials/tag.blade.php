<li class="question-tag">
    <div class="tag-tooltip-content">
        <a class="watch-tag-button" href="/questions?text=%5B{{ str_replace(' ', '%20', $tag->name) }}%5D">
            <svg width="20" height="20" viewBox="0 0 61 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M37.8904 30.8372C37.8904 34.9794 34.5327 38.3372 30.3904 38.3372C26.2484 38.3372 22.8905 34.9794 22.8905 30.8372C22.8905 26.6949 26.2484 23.3372 30.3904 23.3372C34.5327 23.3372 37.8904 26.6949 37.8904 30.8372Z" stroke="black" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M30.3917 13.3372C19.1975 13.3372 9.72183 20.6944 6.53613 30.8372C9.72178 40.9799 19.1975 48.3372 30.3917 48.3372C41.5857 48.3372 51.0614 40.9799 54.2472 30.8372C51.0614 20.6944 41.5857 13.3372 30.3917 13.3372Z" stroke="black" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Watch tag
        </a>
        @if (Auth::user()?->followedTags->contains($tag->id))
            <button data-id="{{ $tag->id }}" class="unfollow-tag-button">
                <svg width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"></path>
                </svg>
                Unfollow tag
            </button>
        @else
            <button data-id="{{ $tag->id }}" class="follow-tag-button">
                <svg width="20" height="20" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.875 15L18.75 13.125H41.25L43.125 15V48.2905L30 40.5127L16.875 48.2905V15ZM20.625 16.875V41.7095L30 36.1538L39.375 41.7095V16.875H20.625Z"></path>
                </svg>
                Follow tag
            </button>
        @endif
    </div>
    {{ $tag->name }}
</li>
