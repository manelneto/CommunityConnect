async function voteAnswer(id, vote) {
    return await fetch('/api/answers/vote', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

async function unvoteAnswer(id, vote) {
    return await fetch('/api/answers/unvote', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

const answerLikes = document.querySelectorAll('.answer-upvotes');

if (answerLikes) {
    answerLikes.forEach((like) => {
        like.addEventListener('click', async (event) => {
            event.preventDefault();
            const id = like.getAttribute('data-id');
            const likesNumber = parseInt(like.textContent);
            const likeSVG = like.querySelector('svg');
            const liked = likeSVG.classList.contains('voted');
            const likeSVGpath = likeSVG.querySelector('path');

            const dislike = document.querySelector(`.answer-downvotes[data-id="${id}"]`);
            const dislikesNumber = parseInt(dislike.textContent);
            const dislikeSVG = dislike.querySelector('svg');
            const disliked = dislikeSVG.classList.contains('voted');
            const dislikeSVGpath = dislikeSVG.querySelector('path');

            if (!liked && !disliked) {
                const voteResponse = await voteAnswer(id, true);
                if (voteResponse.status === 200) {
                    likeSVG.classList.replace('unvoted', 'voted');
                    likeSVGpath.setAttribute('fill', '#38B6FF');
                    likeSVG.previousSibling.textContent = `${likesNumber + 1} `;
                } else {
                    addError('Vote could not be added');
                }

            } else if (liked && !disliked) {
                const unvoteResponse = await unvoteAnswer(id, true);
                if (unvoteResponse.status === 200) {
                    likeSVG.classList.remove('voted', 'unvoted');
                    likeSVGpath.setAttribute('fill', '#ABACB1');
                    likeSVG.previousSibling.textContent = `${likesNumber - 1} `;
                } else {
                    addError('Vote could not be removed');
                }

            } else if (!liked && disliked) {
                const unvoteResponse = await unvoteAnswer(id, false);
                if (unvoteResponse.status === 200) {
                    dislikeSVG.classList.remove('voted', 'unvoted');
                    dislikeSVGpath.setAttribute('fill', '#ABACB1');
                    dislikeSVG.previousSibling.textContent = `${dislikesNumber - 1} `;
                }

                const voteResponse = await voteAnswer(id, true);
                if (voteResponse.status === 200) {
                    likeSVG.classList.remove('unvoted', 'voted');
                    likeSVGpath.setAttribute('fill', '#38B6FF');
                    likeSVG.previousSibling.textContent = `${likesNumber + 1} `;
                } else {
                    addError('Vote could not be added');
                }
            }
        });
    });
}


const answerDislikes = document.querySelectorAll('.answer-downvotes');

if (answerDislikes) {
    answerDislikes.forEach((dislike) => {
        dislike.addEventListener('click', async (event) => {
            event.preventDefault();
            const id = dislike.getAttribute('data-id');
            const dislikesNumber = parseInt(dislike.textContent);
            const dislikeSVG = dislike.querySelector('svg');
            const disliked = dislikeSVG.classList.contains('voted');
            const dislikeSVGpath = dislikeSVG.querySelector('path');

            const like = document.querySelector(`.answer-upvotes[data-id="${id}"]`);
            const likesNumber = parseInt(like.textContent);
            const likeSVG = like.querySelector('svg');
            const liked = likeSVG.classList.contains('voted');
            const likeSVGpath = likeSVG.querySelector('path');

            if (!disliked && !liked) {
                const voteResponse = await voteAnswer(id, false);
                if (voteResponse.status === 200) {
                    dislikeSVG.classList.replace('unvoted', 'voted');
                    dislikeSVGpath.setAttribute('fill', '#38B6FF');
                    dislikeSVG.previousSibling.textContent = `${dislikesNumber + 1} `;
                } else {
                    addError('Vote could not be added');
                }

            } else if (disliked && !liked) {
                const unvoteResponse = await unvoteAnswer(id, false);
                if (unvoteResponse.status === 200) {
                    dislikeSVG.classList.replace('voted', 'unvoted');
                    dislikeSVGpath.setAttribute('fill', '#ABACB1');
                    dislikeSVG.previousSibling.textContent = `${dislikesNumber - 1} `;
                } else {
                    addError('Vote could not be removed');
                }

            } else if (!disliked && liked) {
                const unvoteResponse = await unvoteAnswer(id, true);
                if (unvoteResponse.status === 200) {
                    likeSVG.classList.replace('voted', 'unvoted');
                    likeSVGpath.setAttribute('fill', '#ABACB1');
                    likeSVG.previousSibling.textContent = `${likesNumber - 1} `;
                }

                const voteResponse = await voteAnswer(id, false);
                if (voteResponse.status === 200) {
                    dislikeSVG.classList.replace('unvoted', 'voted');
                    dislikeSVGpath.setAttribute('fill', '#38B6FF');
                    dislikeSVG.previousSibling.textContent = `${dislikesNumber + 1} `;
                } else {
                    addError('Vote could not be added');
                }

            }
        });
    });
}
