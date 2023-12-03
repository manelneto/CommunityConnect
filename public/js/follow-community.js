async function followCommunity(id) {
    await fetch('/api/communities/follow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

async function unfollowCommunity(id) {
    await fetch('/api/communities/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const communities = document.querySelectorAll('.community');

if (communities) {
    communities.forEach((community) => {
        const button = community.querySelector('button');
        const numberFollowers = community.querySelector('.number-followers');
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const id = button.id;
            if (button.classList.contains('follow-community')) {
                followCommunity(id);
                button.textContent = 'Unfollow';
                numberFollowers.textContent = parseInt(numberFollowers.textContent) + 1 + " Followers";
            } else {
                unfollowCommunity(id);
                button.textContent = 'Follow';
                numberFollowers.textContent = parseInt(numberFollowers.textContent) - 1 + " Followers";
            }
            button.classList.toggle('follow-community');
            button.classList.toggle('unfollow-community');
        });
    });
}
