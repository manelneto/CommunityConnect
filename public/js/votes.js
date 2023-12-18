async function vote(id, vote, content, type) {
    return await fetch(`/api/${content}/${type}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

async function voteAnswer(id, vote) {
    return await vote(id, vote, 'answers', 'vote');
}

async function unvoteAnswer(id, vote) {
    return await vote(id, vote, 'answers', 'unvote');
}

async function voteQuestion(id, vote) {
    return await vote(id, vote, 'questions', 'vote');
}

async function unvoteQuestion(id, vote) {
    return await vote(id, vote, 'questions', 'unvote');
}

async function handleVote(event, element, vote) {
    event.preventDefault();

    const id = element.getAttribute('data-id');
    const votesNumber = parseInt(element.textContent);
    const voteSVG = element.querySelector('svg');
    const voted = voteSVG.classList.contains('voted');
    const voteSVGpath = voteSVG.querySelector('path');

    const oppositeSelector = element.classList.contains('answer-upvotes') ? '.answer-downvotes' : '.answer-upvotes';

    const oppositeElement = document.querySelector(`${oppositeSelector}[data-id="${id}"]`);
    const oppositeVotesNumber = parseInt(oppositeElement.textContent);
    const oppositeVoteSVG = oppositeElement.querySelector('svg');
    const oppositeVoted = oppositeVoteSVG.classList.contains('voted');
    const oppositeVoteSVGpath = oppositeVoteSVG.querySelector('path');

    if (!voted && !oppositeVoted) {
        const voteResponse = await voteAnswer(id, vote);
        if (voteResponse.status === 200) {
            voteSVG.classList.replace('unvoted', 'voted');
            voteSVGpath.setAttribute('fill', '#38B6FF');
            voteSVG.previousSibling.textContent = `${votesNumber + 1} `;
        } else {
            addError('Vote could not be added');
        }
    } else if (voted && !oppositeVoted) {
        const unvoteResponse = await unvoteAnswer(id, vote);
        if (unvoteResponse.status === 200) {
            voteSVG.classList.replace('voted', 'unvoted');
            voteSVGpath.setAttribute('fill', '#ABACB1');
            voteSVG.previousSibling.textContent = `${votesNumber - 1} `;
        } else {
            addError('Vote could not be removed');
        }
    } else if (!voted && oppositeVoted) {
        const unvoteResponse = await unvoteAnswer(id, vote);
        if (unvoteResponse.status === 200) {
            oppositeVoteSVG.classList.replace('voted', 'unvoted');
            oppositeVoteSVGpath.setAttribute('fill', '#ABACB1');
            oppositeVoteSVG.previousSibling.textContent = `${oppositeVotesNumber - 1} `;
        } else {
            addError('Vote could not be removed');
        }

        const voteResponse = await voteAnswer(id, vote);
        if (voteResponse.status === 200) {
            voteSVG.classList.replace('unvoted', 'voted');
            voteSVGpath.setAttribute('fill', '#38B6FF');
            voteSVG.previousSibling.textContent = `${votesNumber + 1} `;
        } else {
            addError('Vote could not be added');
        }
    }
}


const answerLikes = document.querySelectorAll('.answer-upvotes');
if (answerLikes) {
    answerLikes.forEach((like) => like.addEventListener('click', handleVote}