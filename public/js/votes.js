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
    return await response.json();
}

const upvoteButton = document.querySelector(".question-upvotes");
const downvoteButton = document.querySelector(".question-downvotes");

if (upvoteButton){
    upvoteButton.addEventListener("click", async () => {
        const response = await handleVote(userId, questionId, true);
        if (response.ok) upvoteButton.textContent = response.likes;
    });
}

if (downvoteButton){
    downvoteButton.addEventListener("click", async () => {
        const response = await handleVote(userId, questionId, false);
        if (response.ok) downvoteButton.textContent = response.dislikes;
    });
}

