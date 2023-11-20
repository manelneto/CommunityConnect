const aboutButton = document.querySelector('#about-button');

if (aboutButton) {
    aboutButton.addEventListener('click', function(event) {
        event.preventDefault();
        const myQuestions = document.querySelector('#my-questions');
        if (myQuestions) {
            hide(myQuestions)
        }
        const myAnswers = document.querySelector('#my-answers');
        if (myQuestions) {
            hide(myAnswers)
        }
    });
}

const questionsButton = document.querySelector('#questions-button');

if (questionsButton) {
    questionsButton.addEventListener('click', function(event) {
        event.preventDefault();
        const myQuestions = document.querySelector('#my-questions');
        if (myQuestions) {
            show(myQuestions)
        }
        const myAnswers = document.querySelector('#my-answers');
        if (myQuestions) {
            hide(myAnswers)
        }
    });
}

const answersButton = document.querySelector('#answers-button');

if (answersButton) {
    answersButton.addEventListener('click', function(event) {
        event.preventDefault();
        const myQuestions = document.querySelector('#my-questions');
        if (myQuestions) {
            hide(myQuestions)
        }
        const myAnswers = document.querySelector('#my-answers');
        if (myQuestions) {
            show(myAnswers)
        }
    });
}
