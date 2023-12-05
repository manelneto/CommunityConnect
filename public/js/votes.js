async function handleVote(userId, questionId, vote){
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

const upvoteButton = document.getElementById("question-upvotes");
const downvoteButton = document.getElementById("question-downvotes");
const likesCount = document.getElementById("likes-count");
const dislikesCount = document.getElementById("dislikes-count");

if (upvoteButton){
    upvoteButton.addEventListener("click", async () => {
        const response = await handleVote(userId, questionId, true);
        if (response.ok){
            const data = await response.json();
            likesCount.textContent = data.likes;
            dislikesCount.textContent = data.dislikes;
        }
    });
}

if (downvoteButton){
    downvoteButton.addEventListener("click", async () => {
        const response = await handleVote(userId, questionId, false);
        if (response.ok){
            const data = await response.json();
            likesCount.textContent = data.likes;
            dislikesCount.textContent = data.dislikes;
        }
    });
}

