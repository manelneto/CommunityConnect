const leaveAnswerCommentForm = document.querySelector(".leave-comment-question");
const leaveAnswerCommentButton = document.querySelector(".add-question-comment-tap")

if (leaveAnswerCommentForm && leaveAnswerCommentButton) {
  leaveAnswerCommentButton.addEventListener("click", () => {
    leaveAnswerCommentForm.classList.toggle("hidden");
  });
}



