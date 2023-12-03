async function followQuestion(id) {
  console.log("following question", id);
  await fetch(`/api/questions/${id}/follow`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: encodeForAjax({ id: id }),
  });
}

async function unfollowQuestion(id) {
  console.log("unfollowing question", id);
  await fetch(`/api/questions/${id}/unfollow`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: encodeForAjax({ id: id }),
  });
}

const questionButtons = document.querySelectorAll(".question-details button");

if (questionButtons) {
  questionButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      const id = button.id;
      if (button.classList.contains("follow-question-button")) {
        followQuestion(id);
        // button.textContent = 'Unfollow';
      } else {
        unfollowQuestion(id);
        // button.textContent = 'Follow';
      }
      button.classList.toggle("follow-question-button");
      button.classList.toggle("unfollow-question-button");
    });
  });
}
