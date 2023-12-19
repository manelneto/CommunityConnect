const tabs = {
    about: {
        button: document.querySelector('#about-button'),
        content: document.querySelector('.about-user'),
    },
    questions: {
        button: document.querySelector('#questions-button'),
        content: document.querySelector('#my-questions'),
    },
    answers: {
        button: document.querySelector('#answers-button'),
        content: document.querySelector('#my-answers'),
    },
};

function hideAllContents() {
    Object.values(tabs).forEach((tab) => {
        if (tab.content) tab.content.style.display = 'none';
    });
}

function deselectAllButtons() {
    Object.values(tabs).forEach((tab) => {
        if (tab.button) tab.button.classList.remove('selected-profile-tab');
    });
}

function showContentAndHighlightButton(selectedTab) {
    hideAllContents();
    deselectAllButtons();

    if (selectedTab.content) {
        selectedTab.content.style.display = 'block';
        selectedTab.button.classList.add('selected-profile-tab');
    }
}

Object.values(tabs).forEach((tab) => {
    if (tab.button) {
        tab.button.addEventListener('click', function (event) {
            event.preventDefault();
            showContentAndHighlightButton(tab);
        });
    }
});

showContentAndHighlightButton(tabs.about);
