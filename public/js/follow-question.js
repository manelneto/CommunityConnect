async function followQuestion(id) {
    await fetch('/api/questions/follow', {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

async function unfollowQuestion(id) {
    await fetch('/api/questions/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

const questionButton = document.querySelector('.question-details button');

if (questionButton) {
    questionButton.addEventListener('click', async (event) => {
        event.preventDefault();
        const id = questionButton.id;
        const questionTooltip = document.querySelector('.follow-question-tooltip');
        if (questionButton.classList.contains('follow-question-button')) {
            await followQuestion(id);
            questionTooltip.textContent = 'Unfollow this question';
        } else {
            await unfollowQuestion(id);
            questionTooltip.textContent = 'Follow this question';
        }
        questionButton.classList.toggle('follow-question-button');
        questionButton.classList.toggle('unfollow-question-button');
    });
}
