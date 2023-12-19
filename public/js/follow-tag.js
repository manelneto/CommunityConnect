async function followTag(id) {
    await fetch('/api/tags/follow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

async function unfollowTag(id) {
    await fetch('/api/tags/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

const followTagButtons = document.querySelectorAll('.tag-tooltip-content button');

if (followTagButtons) {
    followTagButtons.forEach((button) => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();
            const id = button.id;
            const p = button.querySelector('p');
            if (button.classList.contains('follow-tag-button')) {
                await followTag(id);
                p.textContent = 'Unfollow tag';
            } else {
                await unfollowTag(id);
                p.textContent = 'Follow tag';
            }
            button.classList.toggle('follow-tag-button');
            button.classList.toggle('unfollow-tag-button');
        });
    });
}
