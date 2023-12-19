const leaveQuestionCommentForm = document.querySelector('.leave-comment-question');
const leaveQuestionCommentButton = document.querySelector('.add-question-comment-tap');

if (leaveQuestionCommentForm && leaveQuestionCommentButton) {
    leaveQuestionCommentButton.addEventListener('click', () => leaveQuestionCommentForm.classList.toggle('hidden'));
}

const addCommentButtons = document.querySelectorAll('.add-answer-comment-tap');

addCommentButtons.forEach((button) => {
    button.addEventListener('click', function() {
        const commentsContainer = this.closest('.comments');
        const form = commentsContainer.querySelector('.leave-answer-comment');
        form.classList.toggle('hidden');
    });
});
