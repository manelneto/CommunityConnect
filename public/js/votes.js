//TODO: add delete and update support for votes

async function handleVoteQuestion(sessionUserId, questionId, vote) {
    const url = "/api/questions/vote";
    const data = { id_user: sessionUserId, id_question: questionId, vote: vote };
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

async function handleVoteAnswer(sessionUserId, answerId, vote) {
    const url = "/api/answers/vote";
    const data = { id_user: sessionUserId, id_answer: answerId, vote: vote };
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

async function userHasVotedQuestion(sessionUserId, questionId) {
    const url = '/api/questions/vote?' + encodeForAjax({ id_user: sessionUserId, id_question: questionId });
    const response = await fetch(url);
    return await response;
}

async function userHasVotedAnswer(sessionUserId, answerId) {
    const url = '/api/answers/vote?' + encodeForAjax({ id_user: sessionUserId, id_answer: answerId });
    const response = await fetch(url);
    return await response;
}

document.querySelectorAll(".question-upvotes").forEach(async function (element) {
    const questionId = element.getAttribute("data-question-id");
    const checkVote = await userHasVotedQuestion(sessionUserId, questionId);
    if (checkVote.ok) {
        const data = await checkVote.json();
        if (data.hasVoted === true && data.vote === true) {
            element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
        }
    }
    element.addEventListener("click", async () => {
        const response = await handleVoteQuestion(sessionUserId, questionId, true);
        if (response.ok) {
            const data = await response.json();
            element.lastElementChild.textContent = data.likes;
            if (data.type === "create")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            else if (data.type === "delete")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
            else if (data.type === "update"){
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                element.nextElementSibling.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
                element.nextElementSibling.lastElementChild.textContent = data.dislikes;
            }
        }

    });
});

document.querySelectorAll(".question-downvotes").forEach(async function (element) {
    const questionId = element.getAttribute("data-question-id");
    const checkVote = await userHasVotedQuestion(sessionUserId, questionId);
    if (checkVote.ok) {
        const data = await checkVote.json();
        if (data.hasVoted === true && data.vote === false) {
            element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
        }
    }
    element.addEventListener("click", async () => {
        const response = await handleVoteQuestion(sessionUserId, questionId, false);
        if (response.ok) {
            const data = await response.json();
            element.lastElementChild.textContent = data.dislikes;
            if (data.type === "create")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            else if (data.type === "delete")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
            else if (data.type === "update"){
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                element.previousElementSibling.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
                element.previousElementSibling.lastElementChild.textContent = data.likes;
            }
        }

    });
});

document.querySelectorAll(".answer-upvotes").forEach(async function (element) {
    const answerId = element.getAttribute("data-answer-id");
    const checkVote = await userHasVotedAnswer(sessionUserId, answerId);
    if (checkVote.ok) {
        const data = await checkVote.json();
        if (data.hasVoted === true && data.vote === true) {
            element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
        }
    }
    element.addEventListener("click", async () => {
        const response = await handleVoteAnswer(sessionUserId, answerId, true);
        if (response.ok) {
            const data = await response.json();
            element.nextElementSibling.textContent = data.balance;
            if (data.type === "create")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            else if (data.type === "delete")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
            else if (data.type === "update"){
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                element.nextElementSibling.nextElementSibling.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
            }
        }
    });
});

document.querySelectorAll(".answer-downvotes").forEach(async function (element) {
    const answerId = element.getAttribute("data-answer-id");
    const checkVote = await userHasVotedAnswer(sessionUserId, answerId);
    if (checkVote.ok) {
        const data = await checkVote.json();
        if (data.hasVoted === true && data.vote === false) {
            element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
        }
    }
    element.addEventListener("click", async () => {
        const response = await handleVoteAnswer(sessionUserId, answerId, false);
        if (response.ok) {
            const data = await response.json();
            element.previousElementSibling.textContent = data.balance;
            if (data.type === "create")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
            else if (data.type === "delete")
                element.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
            else if (data.type === "update"){
                element.firstElementChild.firstElementChild.setAttribute("fill", "#38B6FF");
                element.previousElementSibling.previousElementSibling.firstElementChild.firstElementChild.setAttribute("fill", "#ABACB1");
            }
        }

    });
});

