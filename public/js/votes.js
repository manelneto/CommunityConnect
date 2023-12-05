async function handleVoteQuestion(userId, questionId, vote){
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

async function handleVoteAnswer(userId, answerId, vote){
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

const upvoteButtonQuestion = document.getElementById("question-upvotes");
const downvoteButtonQuestion = document.getElementById("question-downvotes");
const likesCountQuestion = document.getElementById("likes-count");
const dislikesCountQuestion = document.getElementById("dislikes-count");

if (upvoteButtonQuestion){
    upvoteButtonQuestion.addEventListener("click", async () => {
        const response = await handleVoteQuestion(userId, questionId, true);
        if (response.ok){
            const data = await response.json();
            likesCountQuestion.textContent = data.likes;
            dislikesCountQuestion.textContent = data.dislikes;
        }
    });
}

if (downvoteButtonQuestion){
    downvoteButtonQuestion.addEventListener("click", async () => {
        const response = await handleVoteQuestion(userId, questionId, false);
        if (response.ok){
            const data = await response.json();
            likesCountQuestion.textContent = data.likes;
            dislikesCountQuestion.textContent = data.dislikes;
        }
    });
}

const upvoteButtonAnswer = document.getElementById("answer-upvotes");
const downvoteButtonAnswer = document.getElementById("answer-downvotes");
const votesBalanceAnswer = document.getElementById("balance-votes");

if (upvoteButtonAnswer){
    upvoteButtonAnswer.addEventListener("click", async () => {
        const response = await handleVoteAnswer(userId, answerId, true);
        if (response.ok){
            const data = await response.json();
            votesBalanceAnswer.textContent = data.balance;
        }
    });
}

if (downvoteButtonAnswer){
    downvoteButtonAnswer.addEventListener("click", async () => {
        const response = await handleVoteAnswer(userId, answerId, false);
        if (response.ok){
            const data = await response.json();
            votesBalanceAnswer.textContent = data.balance;
        }
    });
}

