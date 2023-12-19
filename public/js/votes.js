async function requestVote(id, vote, content, type) {
    return await fetch(`/api/${content}/${type}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

async function voteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content) {
    const voteResponse = await requestVote(id, vote, content, 'vote');
    if (voteResponse.status === 200) {
        voteSVG.classList.replace('unvoted', 'voted');
        voteSVGpath.setAttribute('fill', '#38B6FF');
        if (content === 'questions')
            voteSVG.nextSibling.textContent = ` ${votesNumber + 1}`;
        else
            voteSVG.previousSibling.textContent = `${votesNumber + 1} `;
    } else {
        addError('Vote could not be added');
    }
}

async function unvoteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content) {
    const unvoteResponse = await requestVote(id, vote, content, 'unvote');
    if (unvoteResponse.status === 200) {
        voteSVG.classList.replace('voted', 'unvoted');
        voteSVGpath.setAttribute('fill', '#ABACB1');
        if (content === 'questions')
            voteSVG.nextSibling.textContent = ` ${votesNumber - 1}`;
        else
            voteSVG.previousSibling.textContent = `${votesNumber - 1} `;
    } else {
        addError('Vote could not be removed');
    }
}

async function handleVote(event, element, oppositeSelector, vote, content) {
    event.preventDefault();

    const id = element.getAttribute('data-id');
    const votesNumber = parseInt(element.textContent);
    const voteSVG = element.querySelector('svg');
    const voted = voteSVG.classList.contains('voted');
    const voteSVGpath = voteSVG.querySelector('path');

    const oppositeElement = document.querySelector(`${oppositeSelector}[data-id="${id}"]`);
    const oppositeVotesNumber = parseInt(oppositeElement.textContent);
    const oppositeVoteSVG = oppositeElement.querySelector('svg');
    const oppositeVoted = oppositeVoteSVG.classList.contains('voted');
    const oppositeVoteSVGpath = oppositeVoteSVG.querySelector('path');

    if (!voted && !oppositeVoted) {
        // vote
        await voteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content);
    } else if (voted && !oppositeVoted) {
        // remove vote
        await unvoteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content);
    } else if (!voted && oppositeVoted) {
        // swap vote
        await unvoteContent(oppositeVoteSVG, oppositeVoteSVGpath, oppositeVotesNumber, id, !vote, content);
        await voteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content);
    }
}

const questionLikes = document.querySelectorAll('.question-upvotes');
if (questionLikes) {
    questionLikes.forEach((like) => like.addEventListener('click', async (event) => await handleVote(event, like, '.question-downvotes', true, 'questions')));
}

const questionDislikes = document.querySelectorAll('.question-downvotes');
if (questionDislikes) {
    questionDislikes.forEach((dislike) => dislike.addEventListener('click', async (event) => await handleVote(event, dislike, '.question-upvotes', false, 'questions')));
}

const answerLikes = document.querySelectorAll('.answer-upvotes');
if (answerLikes) {
    answerLikes.forEach((like) => like.addEventListener('click', async (event) => await handleVote(event, like, '.answer-downvotes', true, 'answers')));
}

const answerDislikes = document.querySelectorAll('.answer-downvotes');
if (answerDislikes) {
    answerDislikes.forEach((dislike) => dislike.addEventListener('click', async (event) => await handleVote(event, dislike, '.answer-upvotes', false, 'answers')));
}
