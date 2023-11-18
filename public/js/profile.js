const questionsButton = document.querySelector('#questions-button');

if (questionsButton) {
    questionsButton.addEventListener('click', function(event) {
        event.preventDefault();
        const myQuestions = document.querySelector('#my-questions');
        if (myQuestions) {
            myQuestions.toggleAttribute('hidden');
        }
    });
}
