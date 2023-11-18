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

const answersButton = document.querySelector('#answers-button');

if (answersButton) {
    answersButton.addEventListener('click', function(event) {
        event.preventDefault();
        const myAnswers = document.querySelector('#my-answers');
        if (myAnswers) {
            myAnswers.toggleAttribute('hidden');
        }
    });
}
