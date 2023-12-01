async function followCommunity(id) {
    console.log('following community', id);
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
    console.log('unfollowing community', id);
    await fetch('/api/communities/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const communityButtons = document.querySelectorAll('.community button');

if (communityButtons) {
    communityButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const id = button.id;
            if (button.classList.contains('follow-community')) {
                followCommunity(id);
                button.textContent = 'Unfollow';
            } else {
                unfollowCommunity(id);
                button.textContent = 'Follow';
            }
            button.classList.toggle('follow-community');
            button.classList.toggle('unfollow-community');
        });
    });
}
