async function voteQuestion(id, vote) {
    return await fetch('/api/questions/vote', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

async function unvoteQuestion(id, vote) {
    return await fetch('/api/questions/unvote', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

async function likeEventListener(event, like) {
    event.preventDefault();
    const id = like.getAttribute('data-id');
    const likesNumber = parseInt(like.textContent);
    const likeSVG = like.querySelector('svg');
    const liked = likeSVG.classList.contains('voted');
    const likeSVGpath = likeSVG.querySelector('path');

    const dislike = document.querySelector(`.question-downvotes[data-id="${id}"]`);
    const dislikesNumber = parseInt(dislike.textContent);
    const dislikeSVG = dislike.querySelector('svg');
    const disliked = dislikeSVG.classList.contains('voted');
    const dislikeSVGpath = dislikeSVG.querySelector('path');

    if (!liked && !disliked) {
        const voteResponse = await voteQuestion(id, true);
        if (voteResponse.status === 200) {
            likeSVG.classList.replace('unvoted', 'voted');
            likeSVGpath.setAttribute('fill', '#38B6FF');
            likeSVG.nextSibling.textContent = ` ${likesNumber + 1}`;
        } else {
            addError('Vote could not be added');
        }

    } else if (liked && !disliked) {
        const unvoteResponse = await unvoteQuestion(id, true);
        if (unvoteResponse.status === 200) {
            likeSVG.classList.replace('voted', 'unvoted');
            likeSVGpath.setAttribute('fill', '#ABACB1');
            likeSVG.nextSibling.textContent = ` ${likesNumber - 1}`;
        } else {
            addError('Vote could not be removed');
        }

    } else if (!liked && disliked) {
        const unvoteResponse = await unvoteQuestion(id, false);
        if (unvoteResponse.status === 200) {
            dislikeSVG.classList.replace('voted', 'unvoted');
            dislikeSVGpath.setAttribute('fill', '#ABACB1');
            dislikeSVG.nextSibling.textContent = ` ${dislikesNumber - 1}`;
        }

        const voteResponse = await voteQuestion(id, true);
        if (voteResponse.status === 200) {
            likeSVG.classList.replace('unvoted', 'voted');
            likeSVGpath.setAttribute('fill', '#38B6FF');
            likeSVG.nextSibling.textContent = ` ${likesNumber + 1}`;
        } else {
            addError('Vote could not be added');
        }
    }
}

const questionLikes = document.querySelectorAll('.question-upvotes');

if (questionLikes) {
    questionLikes.forEach((like) => {
        like.addEventListener('click', async (event) => likeEventListener(event, like));
    });
}

async function dislikeEventListener(event, dislike) {
    event.preventDefault();
    const id = dislike.getAttribute('data-id');
    const dislikesNumber = parseInt(dislike.textContent);
    const dislikeSVG = dislike.querySelector('svg');
    const disliked = dislikeSVG.classList.contains('voted');
    const dislikeSVGpath = dislikeSVG.querySelector('path');

    const like = document.querySelector(`.question-upvotes[data-id="${id}"]`);
    const likesNumber = parseInt(like.textContent);
    const likeSVG = like.querySelector('svg');
    const liked = likeSVG.classList.contains('voted');
    const likeSVGpath = likeSVG.querySelector('path');

    if (!disliked && !liked) {
        const voteResponse = await voteQuestion(id, false);
        if (voteResponse.status === 200) {
            dislikeSVG.classList.replace('unvoted', 'voted');
            dislikeSVGpath.setAttribute('fill', '#38B6FF');
            dislikeSVG.nextSibling.textContent = ` ${dislikesNumber + 1}`;
        } else {
            addError('Vote could not be added');
        }

    } else if (disliked && !liked) {
        const unvoteResponse = await unvoteQuestion(id, false);
        if (unvoteResponse.status === 200) {
            dislikeSVG.classList.replace('voted', 'unvoted');
            dislikeSVGpath.setAttribute('fill', '#ABACB1');
            dislikeSVG.nextSibling.textContent = ` ${dislikesNumber - 1}`;
        } else {
            addError('Vote could not be removed');
        }

    } else if (!disliked && liked) {
        const unvoteResponse = await unvoteQuestion(id, true);
        if (unvoteResponse.status === 200) {
            likeSVG.classList.replace('voted', 'unvoted');
            likeSVGpath.setAttribute('fill', '#ABACB1');
            likeSVG.nextSibling.textContent = ` ${likesNumber - 1}`;
        }

        const voteResponse = await voteQuestion(id, false);
        if (voteResponse.status === 200) {
            dislikeSVG.classList.replace('unvoted', 'voted');
            dislikeSVGpath.setAttribute('fill', '#38B6FF');
            dislikeSVG.nextSibling.textContent = ` ${dislikesNumber + 1}`;
        } else {
            addError('Vote could not be added');
        }

    }
}

const questionDislikes = document.querySelectorAll('.question-downvotes');

if (questionDislikes) {
    questionDislikes.forEach((dislike) => {
        dislike.addEventListener('click', async (event) => dislikeEventListener(event, dislike));
    });
}
