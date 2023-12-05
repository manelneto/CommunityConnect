async function handleVoteQuestion(userId, questionId, vote) {
    const url = "/api/questions/vote";
    const data = { id_user: userId, id_question: questionId, vote: vote };
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    const response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
    });
    return await response;
}

async function handleVoteAnswer(userId, answerId, vote) {
    const url = "/api/answers/vote";
    const data = { id_user: userId, id_answer: answerId, vote: vote };
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    const response = await fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
    });
    return await response;
}

async function userHasVotedQuestion(userId, questionId) {
    const url = '/api/questions/vote?' + encodeForAjax({ id_user: userId, id_question: questionId });
    const response = await fetch(url);
    return await response;
}

async function userHasVotedAnswer(userId, answerId) {
    const url = '/api/answers/vote?' + encodeForAjax({ id_user: userId, id_answer: answerId });
    const response = await fetch(url);
    return await response;
}
const upvoteButtonQuestion = document.getElementById("question-upvotes");
const downvoteButtonQuestion = document.getElementById("question-downvotes");
const likesCountQuestion = document.getElementById("likes-count");
const dislikesCountQuestion = document.getElementById("dislikes-count");

if (upvoteButtonQuestion) {
    upvoteButtonQuestion.addEventListener("click", async () => {
        const response = await handleVoteQuestion(userId, questionId, true);
        if (response.ok) {
            const data = await response.json();
            likesCountQuestion.textContent = data.likes;
            dislikesCountQuestion.textContent = data.dislikes;
            upvoteButtonQuestion.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            upvoteButtonQuestion.style.color = "#38B6FF";
        }
    });
}

if (downvoteButtonQuestion) {
    downvoteButtonQuestion.addEventListener("click", async () => {
        const response = await handleVoteQuestion(userId, questionId, false);
        if (response.ok) {
            const data = await response.json();
            likesCountQuestion.textContent = data.likes;
            dislikesCountQuestion.textContent = data.dislikes;
            downvoteButtonQuestion.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            downvoteButtonQuestion.style.color = "#38B6FF";
        }
    });
}

const upvoteButtonAnswer = document.getElementById("answer-upvotes");
const downvoteButtonAnswer = document.getElementById("answer-downvotes");
const votesBalanceAnswer = document.getElementById("balance-votes");

if (upvoteButtonAnswer) {
    upvoteButtonAnswer.addEventListener("click", async () => {
        const response = await handleVoteAnswer(userId, answerId, true);
        if (response.ok) {
            const data = await response.json();
            votesBalanceAnswer.textContent = data.balance;
            upvoteButtonAnswer.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            votesBalanceAnswer.style.color = "#38B6FF"; 
        }
    });
}

if (downvoteButtonAnswer) {
    downvoteButtonAnswer.addEventListener("click", async () => {
        const response = await handleVoteAnswer(userId, answerId, false);
        if (response.ok) {
            const data = await response.json();
            votesBalanceAnswer.textContent = data.balance;
            downvoteButtonAnswer.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            votesBalanceAnswer.style.color = "#38B6FF"; 
        }
    });
}


window.onload = async () => {
    if (upvoteButtonAnswer || downvoteButtonAnswer) {
        const checkVote = await userHasVotedAnswer(userId, answerId);
        if (checkVote.ok) {
            const data = await checkVote.json();
            if (data.hasVoted === true && data.vote === true) {
                upvoteButtonAnswer.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                votesBalanceAnswer.style.color = "#38B6FF"; 
            }
            else if (data.hasVoted === true && data.vote === false) {
                downvoteButtonAnswer.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                votesBalanceAnswer.style.color = "#38B6FF"; 
            }
        }
    }

    if (upvoteButtonQuestion || downvoteButtonQuestion) {
        const checkVote = await userHasVotedQuestion(userId, questionId);
        if (checkVote.ok) {
            const data = await checkVote.json();
            if (data.hasVoted === true && data.vote === true) {
                upvoteButtonQuestion.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                upvoteButtonQuestion.style.color = "#38B6FF";
            }
            else if (data.hasVoted === true && data.vote === false) {
                downvoteButtonQuestion.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                downvoteButtonQuestion.style.color = "#38B6FF";
            }
        }
    }
}
