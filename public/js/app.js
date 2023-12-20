let users = Array();
let blocked = Array();
let unblocked = Array();
let tags = Array();

window.onload = async () => {
    const admin = document.querySelector('#admin-page');
    const user = document.querySelector('.user-details-input');
    if (admin || user) {
        const url = '../../api/users';
        const response = await fetch(url);
        const allUsers = await response.json();
        users = allUsers.map(user => [user.username, user.id, user.email]).filter(Boolean).sort((a, b) => (a[0].localeCompare(b[0])));
        blocked = allUsers.filter(user => user.blocked).map(user => [user.username, user.id]).sort((a, b) => (a[0].localeCompare(b[0])));
        unblocked = allUsers.filter(user => !user.blocked).map(user => [user.username, user.id]).sort((a, b) => (a[0].localeCompare(b[0])));

        const inputUser = document.querySelector('#user');
        if (inputUser) {
            autocomplete(users, inputUser, inputUser);
        }

        const inputBlock = document.querySelector('#block-user');
        const outputBlock = document.querySelector('#block-user + input');
        if (inputBlock && outputBlock) {
            autocomplete(unblocked, inputBlock, outputBlock)
        }

        const inputUnblock = document.querySelector('#unblock-user');
        const outputUnblock = document.querySelector('#unblock-user + input');
        if (inputUnblock && outputUnblock) {
            autocomplete(blocked, inputUnblock, outputUnblock)
        }
    }

    const editQuestion = document.querySelector('#question-edit');
    const createQuestion = document.querySelector('#create-question');
    if (admin || editQuestion || createQuestion) {
        const url = '../../api/tags';
        const response = await fetch(url);
        const allTags = await response.json();
        tags = allTags.map(tag => [tag.name, tag.id]).filter(Boolean).sort((a, b) => (a[0].localeCompare(b[0])));

        const inputDeleteTag = document.querySelector('#delete-tag');
        const outputDeleteTag = document.querySelector('#delete-tag + input');
        if (inputDeleteTag && outputDeleteTag) {
            autocomplete(tags, inputDeleteTag, outputDeleteTag);
        }

        const inputEditTag = document.querySelector('#old-tag-admin');
        const outputEditTag = document.querySelector('#old-tag-admin + input');
        if (inputEditTag && outputDeleteTag) {
            autocomplete(tags, inputEditTag, outputEditTag);
        }

        const inputTagEditQuestion = document.querySelector('#property-tags > #add-tag');
        if (inputTagEditQuestion) {
            autocomplete(tags, inputTagEditQuestion, inputTagEditQuestion);
            inputTagEditQuestion.addEventListener('keydown', async function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    addButton(inputTagEditQuestion);
                }
            });
        }

        const inputTagCreateQuestion = document.querySelector('#tag-ask-question');
        if (inputTagCreateQuestion) {
            autocomplete(tags, inputTagCreateQuestion, inputTagCreateQuestion);
            inputTagCreateQuestion.addEventListener('keydown', async function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    addButton(inputTagCreateQuestion);
                }
            });
        }
    }
};

/* AJAX */

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

/* addButton() */

function addButton(inputTag) {
    const tagName = inputTag.value;
    const tagId = inputTag.getAttribute('value');

    if (!tags.some((element) => element[1] === parseInt(tagId))) {
        inputTag.value = "";
        addError("Tag doesn't exist");
        return;
    }

    const button = document.createElement('button');
    button.classList.add('all-buttons');
    button.textContent = 'X';
    button.style.width = '20px';
    button.style.padding = '0';

    button.addEventListener('click', function (event) {
        event.preventDefault();
        const tag = event.target.parentNode;
        tag.remove();
    });

    const p = document.createElement('div');
    p.classList.add('all-tags');
    p.textContent = tagName;
    p.id = tagId;

    p.insertBefore(button, p.firstChild);

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = `tags-${tagId}`;
    input.value = tagId;

    p.appendChild(input);

    const section = document.querySelector('#property-tags');
    section.appendChild(p);

    inputTag.value = "";
}

/* addError() */

function addError(text) {
    if (document.querySelector('#errors')) {
        const list = document.querySelector('#errors ul');

        const error = document.createElement('li');
        error.textContent = text;

        list.appendChild(error);
    } else {
        const errors = document.createElement('section');
        errors.id = 'errors'

        const list = document.createElement('ul');

        const error = document.createElement('li');
        error.textContent = text;

        list.appendChild(error);
        errors.appendChild(list);

        document.querySelector('body').appendChild(errors);
    }
    window.setTimeout(() => {
        const errors = document.querySelector('#errors ul');
        errors.firstElementChild.remove();
        if (!errors.querySelector('li')) {
            errors.parentElement.remove();
        }
    }, 7500);
}

window.setTimeout(() => {
    const errors = document.querySelector('#errors ul');
    if (errors) {
        errors.parentElement.remove();
        errors.remove();
    }
}, 7500);

window.setTimeout(() => {
    const success = document.querySelector('#success');
    if (success) {
        success.remove();
    }
}, 7500);

/* Autocomplete */

function autocomplete(array, input, output) {
    let matching = Array();
    let index = 0;

    input.addEventListener('input', () => {
        const inputValue = input.value.toUpperCase();

        if (inputValue === '') return;

        const match = array.find((element) => element[0].toUpperCase() === inputValue);
        if (match) {
            output.setAttribute('value', match[1]);
        } else {
            output.setAttribute('value', '0');
        }

        matching = array.filter(value => value && value[0].toUpperCase().startsWith(inputValue)).filter(Boolean);
    });

    input.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matching.length > 0) {
                index = (index + 1) % matching.length;
                input.value = matching[index][0];
                output.setAttribute('value', matching[index][1]);
            }
        }
    });
}

/* Admin: find a user */

const findButton = document.getElementById('find-user');

if (findButton) {
    findButton.addEventListener('click', (event) => {
        event.preventDefault();
        const user = document.getElementById('user');
        const id = user.getAttribute('value');
        window.location.href = `../../users/${id}`;
    });
}

/* Answers: display form to edit */

const editAnswers = document.querySelectorAll('.answer');

if (editAnswers) {
    editAnswers.forEach((answer) => {
        const button = answer.querySelector('.edit');
        if (button) {
            const id = button.getAttribute('data-id');
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const file = answer.querySelector('.file');
                if (file) {
                    file.remove();
                }

                const paragraphs = answer.querySelectorAll('.answer .description');
                const array = Array();
                paragraphs.forEach((paragraph) => {
                    array.push(paragraph.textContent);
                    paragraph.remove();
                });
                const description = array.join('');

                const label1 = document.createElement('label');
                label1.setAttribute('for', `content-${id}`);
                label1.classList.add('label-content');
                label1.textContent = 'Content';

                const textarea = document.createElement('textarea');
                textarea.id = `content-${id}`;
                textarea.classList.add('description');
                textarea.classList.add('non-movable-textarea');
                textarea.name = 'content';
                textarea.cols = 40;
                textarea.rows = 4;
                textarea.placeholder = 'Type in your answer here';
                textarea.value = description;

                const label2 = document.createElement('label');
                label2.setAttribute('for', `file-${id}`);
                label2.classList.add('label-file');
                label2.textContent = 'File';

                const input = document.createElement('input');
                input.id = `file-${id}`;
                input.type = 'file';
                input.name = 'file';
                input.accept = 'image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt';

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'type';
                hidden.value = 'answer';

                const form = answer.querySelector('form');
                const buttons = form.querySelector('.answer-buttons');
                form.insertBefore(label1, buttons);
                form.insertBefore(textarea, buttons);
                form.insertBefore(label2, buttons);
                form.insertBefore(input, buttons);
                form.insertBefore(hidden, buttons);

                const save = document.createElement('button');
                save.classList.add('edit');
                save.formAction = `../../answers/${id}`;
                save.textContent = 'Save';

                buttons.insertBefore(save, button);
                button.remove();
            });
        }
    });
}

/* Answers: mark as correct and delete mark */

async function markAnswer(id) {
    await fetch('/api/answers/{id}/correct', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

async function deleteMarkAnswer(id) {
    await fetch('/api/answers/{id}/incorrect', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const answers = document.querySelectorAll('.answer');

if (answers) {
    answers.forEach((answer) => {
        const button = answer.querySelector('.mark');
        if (button) {
            button.addEventListener('click', async function (event) {
                event.preventDefault();
                const id = button.getAttribute('data-id');
                if (button.classList.contains('mark-correct')) {
                    await markAnswer(id);
                    button.textContent = 'Remove correct mark';

                    const path1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path1.setAttribute('fill', '#c8e6c9');
                    path1.setAttribute('d', 'M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z');

                    const path2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path2.setAttribute('fill', '#4caf50');
                    path2.setAttribute('d', 'M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z');

                    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    svg.classList.add('icon-correct');
                    svg.setAttribute('viewBox', '0 0 48 48');
                    svg.setAttribute('width', '25px');
                    svg.setAttribute('height', '25px');

                    svg.appendChild(path1);
                    svg.appendChild(path2);

                    answer.querySelector('header').appendChild(svg);
                } else {
                    await deleteMarkAnswer(id);
                    button.textContent = 'Mark as correct';
                    const iconCorrect = answer.querySelector('.icon-correct');
                    iconCorrect.remove();
                }
                button.classList.toggle('mark-correct');
                button.classList.toggle('mark-incorrect');
            });
        }
    });
}

/* Comments: display form to add */

const leaveQuestionCommentForm = document.querySelector('.leave-comment-question');
const leaveQuestionCommentButton = document.querySelector('.add-question-comment-tap');

if (leaveQuestionCommentForm && leaveQuestionCommentButton) {
    leaveQuestionCommentButton.addEventListener('click', () => leaveQuestionCommentForm.classList.toggle('hidden'));
}

const addCommentButtons = document.querySelectorAll('.add-answer-comment-tap');

addCommentButtons.forEach((button) => {
    button.addEventListener('click', function () {
        const commentsContainer = this.closest('.comments');
        const form = commentsContainer.querySelector('.leave-answer-comment');
        form.classList.toggle('hidden');
    });
});

/* Communities: follow and unfollow */

async function followCommunity(id) {
    await fetch('/api/communities/follow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

async function unfollowCommunity(id) {
    await fetch('/api/communities/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const communities = document.querySelectorAll('.community');

if (communities) {
    communities.forEach((community) => {
        const button = community.querySelector('button');
        const numberFollowers = community.querySelector('.number-followers');

        if (button) {
            button.addEventListener('click', async (event) => {
                event.preventDefault();
                const id = button.id;
                if (button.classList.contains('follow-community')) {
                    await followCommunity(id);
                    button.textContent = 'Unfollow';
                    numberFollowers.textContent = parseInt(numberFollowers.textContent) + 1 + ' Followers';
                } else {
                    await unfollowCommunity(id);
                    button.textContent = 'Follow';
                    numberFollowers.textContent = parseInt(numberFollowers.textContent) - 1 + ' Followers';
                }
                button.classList.toggle('follow-community');
                button.classList.toggle('unfollow-community');
            });
        }
    });
}

/* Errors: input validation */

async function checkUsernameOrEmailExists(usernameOrEmail) {
    return users.some((user) => (user[0] === usernameOrEmail || user[2] === usernameOrEmail));
}

async function checkTagExists(tag) {
    return tags.some((element) => element[0] === tag);
}

function validateUsernamePattern(username) {
    const regex = /^[a-zA-Z0-9_]+$/; // accepts letters, numbers, underscore
    return regex.test(username);
}

function validateEmailPattern(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$/; // accepts letters, numbers, underscore, dot, dash
    return regex.test(email);
}

function displaySuccess(input) {
    input.style.border = '2px solid green';
    const nextElementSibling = input.nextElementSibling;
    if (nextElementSibling && nextElementSibling.classList.contains('error')) {
        nextElementSibling.remove();
    }
}

function displayError(input, message) {
    input.style.border = '2px solid red';
    const p = document.createElement('p');
    p.textContent = message;
    p.style.color = 'red';
    p.style.fontSize = '12px';
    p.classList.add('error');
    const nextElementSibling = input.nextElementSibling;
    if (nextElementSibling) {
        if (nextElementSibling.classList.contains('error')) {
            nextElementSibling.textContent = message;
        } else {
            input.parentNode.insertBefore(p, nextElementSibling);
        }
    } else {
        input.parentNode.appendChild(p)
    }
}

const usernameOrEmailInput = document.querySelector('#username_or_email.user-details-input ');
if (usernameOrEmailInput) {
    usernameOrEmailInput.addEventListener('blur', async () => {
        if (usernameOrEmailInput.value !== '') {
            if (!await checkUsernameOrEmailExists(usernameOrEmailInput.value)) {
                displayError(usernameOrEmailInput, 'User does not exist');
            } else {
                displaySuccess(usernameOrEmailInput);
            }
        }
    });
}

const usernameInput = document.querySelector('#username.user-details-input ');
if (usernameInput) {
    const initialValue = usernameInput.value;
    usernameInput.addEventListener('blur', async () => {
        if (usernameInput.value !== initialValue) {
            if (!validateUsernamePattern(usernameInput.value)) {
                displayError(usernameInput, 'Username can only contain letters, numbers and underscores')
            } else if (await checkUsernameOrEmailExists(usernameInput.value)) {
                displayError(usernameInput, 'Username is already taken');
            } else {
                displaySuccess(usernameInput);
            }
        }
    });
}

const emailInput = document.querySelector('#email.user-details-input');
if (emailInput) {
    const initialValue = emailInput.value;
    emailInput.addEventListener('blur', async () => {
        if (emailInput.value !== initialValue) {
            if (!validateEmailPattern(emailInput.value)) {
                displayError(emailInput, 'Invalid email format');
            } else if (await checkUsernameOrEmailExists(emailInput.value)) {
                displayError(emailInput, 'Email is already taken');
            } else {
                displaySuccess(emailInput);
            }
        }
    });
}

const passwordInput = document.querySelector('#password.user-details-input');
const passwordConfirmationInput = document.querySelector('#password_confirmation.user-details-input');

if (passwordInput && passwordConfirmationInput) {
    passwordInput.addEventListener('blur', async () => {
        if (passwordInput.value !== '') {
            if (passwordInput.value.length < 8) {
                displayError(passwordInput, 'Password must contain at least 8 characters');
            } else {
                displaySuccess(passwordInput);
            }
        }
    });

    passwordConfirmationInput.addEventListener('blur', async () => {
        if (passwordConfirmationInput.value !== '') {
            if (passwordConfirmationInput.value.length < 8) {
                displayError(passwordConfirmationInput, 'Password must contain at least 8 characters');
            } else if (passwordConfirmationInput.value !== passwordInput.value) {
                displayError(passwordConfirmationInput, "Passwords don't match");
            } else {
                displaySuccess(passwordConfirmationInput);
            }
        }
    });
}

const addTagInput = document.querySelector('#add-tag-admin.user-details-input');
if (addTagInput) {
    addTagInput.addEventListener('blur', async () => {
        if (addTagInput.value !== '') {
            if (await checkTagExists(addTagInput.value)) {
                displayError(addTagInput, 'Tag already exists');
            } else {
                displaySuccess(addTagInput);
            }
        }
    })
}

const oldEditTagInput = document.querySelector('#old-tag-admin.user-details-input');
if (oldEditTagInput) {
    oldEditTagInput.addEventListener('blur', async () => {
        if (oldEditTagInput.value !== '') {
            if (!await checkTagExists(oldEditTagInput.value)) {
                displayError(oldEditTagInput, "Tag doesn't exist");
            } else {
                displaySuccess(oldEditTagInput);
            }
        }
    })
}

const newEditTagInput = document.querySelector('#new-tag-admin.user-details-input');
if (newEditTagInput) {
    newEditTagInput.addEventListener('blur', async () => {
        if (newEditTagInput.value !== '') {
            if (await checkTagExists(newEditTagInput.value)) {
                displayError(newEditTagInput, "Tag already exists");
            } else {
                displaySuccess(newEditTagInput);
            }
        }
    })
}

const deleteTagInput = document.querySelector('#delete-tag.user-details-input');
if (deleteTagInput) {
    deleteTagInput.addEventListener('blur', async () => {
        if (deleteTagInput.value !== '') {
            if (!await checkTagExists(deleteTagInput.value)) {
                displayError(deleteTagInput, "Tag doesn't exist");
            } else {
                displaySuccess(deleteTagInput);
            }
        }
    })
}

/* Password: display form to edit */

function toggle(element) {
    if (element.style.display === 'none' || !element.style.display) {
        element.style.display = 'flex';
    } else {
        element.style.display = 'none';
    }
}

const button = document.querySelector('#edit-password');
if (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const fields = document.querySelectorAll('.edit-password');
        if (fields) {
            fields.forEach((field) => {
                toggle(field);
                field.value = '';
            });
        }
    });
}

/* Password: forgot and send email */

const forgotPassword = document.querySelector('#forgot-password');

if (forgotPassword) {
    forgotPassword.addEventListener('click', (event) => {
        event.preventDefault();
        forgotPassword.remove();
        document.querySelector('#password-group').remove();
        document.querySelector('#sign-page-form button').textContent = 'Send Email';
        document.querySelector('#sign-page-form').action = "../mail"
    });
}

/* Profile: hide and show sections */

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

/* Notifications: mark as read */

async function readNotification(id) {
    await fetch('/api/notifications/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const viewIcons = document.querySelectorAll('.view-icon');
const notificationsNumber = document.querySelector('.notifications-number');

if (viewIcons) {
    viewIcons.forEach((viewIcon) => {
        viewIcon.addEventListener('click', async (event) => {
            event.preventDefault();
            const id = viewIcon.id;
            viewIcon.previousElementSibling.remove();
            viewIcon.remove();
            notificationsNumber.textContent = `${parseInt(notificationsNumber.textContent) - 1}`;
            await readNotification(id);
        });

        viewIcon.addEventListener('mouseover', (event) => {
            event.preventDefault();
            viewIcon.previousElementSibling.style.display = 'block';
        });

        viewIcon.addEventListener('mouseout', (event) => {
            event.preventDefault();
            viewIcon.previousElementSibling.style.display = 'none';
        });
    });
}

/* Notifications: receive and display */

const pusher = new Pusher("96d60c26f4314399aa8b", {
    cluster: "eu",
    encrypted: true
});

function getUserId() {
    const link = document.querySelector('.my-account-button');
    if (link) {
        return link.href.split('/').pop();
    }
}

function addNotification(title, notification) {
    const article = document.createElement('article');
    article.classList.add('notification');

    const h3 = document.createElement('h3');
    h3.innerHTML = title;

    const a = document.createElement('a');
    a.href = `/questions/${notification.id_question}`;
    a.innerHTML = notification.message;

    article.appendChild(h3);
    article.appendChild(a);

    const notifications = document.getElementById('notifications');
    notifications.appendChild(article);

    window.setTimeout(() => document.getElementById('notifications').firstElementChild.remove(), 15000);
}

const channel = pusher.subscribe('CommunityConnect');

channel.bind('answer', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New answer', notification);
    }
});

channel.bind('commentQuestion', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New comment on your question', notification);
    }
});

channel.bind('commentAnswer', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New comment on your answer', notification);
    }
});

channel.bind('voteQuestion', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New vote on your question', notification);
    }
});

channel.bind('voteAnswer', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New vote on your answer', notification);
    }
});

/* Notifications: show on profile */

const notificationIcon = document.querySelector('.notifications-icon');
const notificationsContainer = document.querySelector('.notifications');

if (notificationIcon && notificationsContainer) {
    notificationIcon.addEventListener('click', (event) => {
        event.preventDefault();
        if (notificationsContainer.style.display === 'none' || !notificationsContainer.style.display) {
            notificationsContainer.style.display = 'block';
        } else {
            notificationsContainer.style.display = 'none';
        }
    });
}

/* Questions: filters */

let currentPage = 1;
let isFetching = false;

const filtersButton = document.querySelector("#filters-button");

if (filtersButton) {
    filtersButton.addEventListener('click', function (event) {
        event.preventDefault();
        const questionsFilters = document.querySelector('#questions-filters');
        if (questionsFilters) {
            questionsFilters.toggleAttribute('hidden');
        }
    });
}

const applyButton = document.querySelector('#apply-button');

if (applyButton) {
    applyButton.addEventListener("click", async function (event) {
        event.preventDefault();

        currentPage = 1;
        const questions = await getQuestions(currentPage);

        const questionsCountElement = document.querySelector("#questions-number");
        if (questionsCountElement) {
            questionsCountElement.textContent = `${questions.total} questions`;
        }

        const section = document.querySelector("#questions");
        section.innerHTML = "";

        questions.data.forEach((question) => {
            const newQuestion = addQuestion(question);
            section.append(newQuestion);
        });

        isFetching = false;
    });

    window.addEventListener('scroll', async () => {
        if (Math.ceil(window.innerHeight + window.scrollY) >= document.body.scrollHeight && !isFetching) {
            // user is at the end of the screen
            await loadMoreQuestions();
        }
    });
}

async function loadMoreQuestions() {
    currentPage++;
    const newQuestions = await getQuestions(currentPage);

    const section = document.querySelector('#questions');
    newQuestions.data.forEach((question) => {
        const newQuestion = addQuestion(question);
        section.append(newQuestion);
    });

    isFetching = false;
}

async function getQuestions(currentPage) {
    let communities = Array();
    const usernameButton = document.querySelector(".my-account-button");
    if (usernameButton) {
        const username = usernameButton.textContent.split('(')[1];
        const user = await fetchUser(username.slice(0, -1));
        user[0]['communities'].forEach((community) => communities.push(community['id']));
    }

    isFetching = true;
    const after = document.querySelector("#after").value || "2020-01-01";
    const before = document.querySelector("#before").value || "2030-12-31";
    let community = window.location.pathname.split('/').pop();
    if (community === 'questions') {
        community = 0;
        communities = 0;
    } else if (community === 'feed') {
        community = -1;
    }

    const text = document.querySelector(".live-search").value;
    const sort = document.querySelector('input[name="sort"]:checked').value;

    return await fetchQuestions(after, before, community, communities, text, sort, currentPage);
}

async function fetchQuestions(after, before, community, communities, text, sort, page) {
    const url =
        "/api/questions?" +
        encodeForAjax({
            after: after,
            before: before,
            community: community,
            communities: communities,
            text: text,
            sort: sort,
            page: page,
        });

    const response = await fetch(url);
    return await response.json();
}

function addQuestion(question) {
    const edited = question.last_edited ? `<p class="question-edited-date">Edited: ${question.last_edited}</p>` : '';

    let content = '';
    question.content.split("\n").forEach((paragraph) => content += `<p class="question-description">${paragraph}</p>`)

    const file = question.file ? `<p class="file"><a href="/${question.file}" target="_blank">Download file here</a></p>` : '';

    const id = getUserId();

    const like = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    like.classList.add('unvoted');
    like.setAttribute('width', '18');
    like.setAttribute('height', '12');
    like.setAttribute('viewBox', '0 0 18 12');
    like.setAttribute('fill', 'none');

    const likePath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    likePath.setAttribute('d', 'M0.000244141 12L9.00024 0L18.0002 12H0.000244141Z');
    likePath.setAttribute('fill', '#ABACB1')

    like.appendChild(likePath);

    question.likes.forEach((like) => {
        if (like.id_user === id && like.likes) {
            like.classList.replace('unvoted', 'voted');
            likePath.setAttribute('fill', '#38B6FF');
        }
    });

    const dislike = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    dislike.classList.add('unvoted');
    dislike.setAttribute('width', '18');
    dislike.setAttribute('height', '12');
    dislike.setAttribute('viewBox', '0 0 18 12');
    dislike.setAttribute('fill', 'none');

    const dislikePath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    dislikePath.setAttribute('d', `M0.000244141 0L9.00024 12L18.0002 0H0.000244141Z`);
    dislikePath.setAttribute('fill', '#ABACB1')

    dislike.appendChild(dislikePath);

    question.dislikes.forEach((dislike) => {
        if (dislike.id_user === id && like.likes) {
            dislike.classList.replace('unvoted', 'voted');
            dislikePath.setAttribute('fill', '#38B6FF');
        }
    });

    const newQuestion = document.createElement('article');
    newQuestion.classList.add('question-container');
    newQuestion.innerHTML = `
        <h3>Question</h3>
        <img class="member-pfp question-member-pfp" src="../${question.user.image}" alt="User's profile picture"/>
        <article class="content-right">
            <h3>Question</h3>
            <header class="question-details">
                <a class="question-username" href="../users/${question.user.id}">${question.user.username}</a>
                <p class="question-asked-date">Asked: ${question.date}</p>
                <p class="question-community">In: <a class="question-community-click" href="../communities/${question.community.id}">${question.community.name}</a></p>
                ${edited}
            </header>
            <h2 class="question-title"><a href="../questions/${question.id}">${question.title}</a></h2>
            ${content}
            ${file}
            <footer class="answers-details">
                <a class="question-answer-btn" href="../questions/${question.id}#answers">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.8 4.8H20.4V15.6H4.8V18C4.8 18.66 5.34 19.2 6 19.2H19.2L24 24V6C24 5.34 23.46 4.8 22.8 4.8ZM18 12V1.2C18 0.54 17.46 0 16.8 0H1.2C0.54 0 0 0.54 0 1.2V18L4.8 13.2H16.8C17.46 13.2 18 12.66 18 12Z" fill="#abacb1" />
                    </svg>
                    ${question.answers_count} Answers
                </a>
                <p class="question-upvotes" data-id="${question.id}"> ${question.likes_count}</p>
                <p class="question-downvotes" data-id="${question.id}"> ${question.dislikes_count}</p>
            </footer>
        </article>
    `;

    const upvote = newQuestion.querySelector('.question-upvotes');
    upvote.prepend(like);
    upvote.addEventListener('click', async (event) => await handleVote(event, upvote, '.question-downvotes', true, 'questions'));

    const downvote = newQuestion.querySelector('.question-downvotes');
    downvote.prepend(dislike);
    downvote.addEventListener('click', async (event) => await handleVote(event, downvote, '.question-upvotes', false, 'questions'));

    return newQuestion;
}

async function fetchUser(username) {
    const url = "/api/users?" + encodeForAjax({username: username});
    const response = await fetch(url);
    return await response.json();
}

/* Questions: follow and unfollow */

async function followQuestion(id) {
    await fetch('/api/questions/follow', {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

async function unfollowQuestion(id) {
    await fetch('/api/questions/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

const questionButton = document.querySelector('.question-details button');

if (questionButton) {
    questionButton.addEventListener('click', async (event) => {
        event.preventDefault();
        const id = questionButton.id;
        const questionTooltip = document.querySelector('.follow-question-tooltip');
        if (questionButton.classList.contains('follow-question-button')) {
            await followQuestion(id);
            questionTooltip.textContent = 'Unfollow this question';
        } else {
            await unfollowQuestion(id);
            questionTooltip.textContent = 'Follow this question';
        }
        questionButton.classList.toggle('follow-question-button');
        questionButton.classList.toggle('unfollow-question-button');
    });
}

/* Responsiveness: search bar */

const searchBar = document.querySelector('.live-search');
const searchBarInfo = document.querySelector('.search-bar-info');

if (searchBar && searchBarInfo) {
    searchBar.addEventListener('click', function (event) {
        event.stopPropagation();
        searchBarInfo.classList.toggle('hidden', false);
    });

    document.addEventListener('click', function (event) {
        if (!searchBar.contains(event.target) && !searchBarInfo.contains(event.target)) {
            searchBarInfo.classList.add('hidden');
        }
    });
}

/* Responsiveness: sidebar */

const navBarMobile = document.querySelector('.mobile-aside-bar');
const openButton = document.querySelector('.side-bar-icon');
const closeButton = document.querySelector('.close-mobile-bar');

if (closeButton && navBarMobile) {
    closeButton.addEventListener('click', function () {
        navBarMobile.classList.toggle('nav-bar-hidden');
    });
}

if (openButton && navBarMobile) {
    openButton.addEventListener('click', function () {
        navBarMobile.classList.toggle('nav-bar-hidden');
        navBarMobile.style.visibility = 'visible';
        navBarMobile.style.opacity = '1';
    });
}

/* Tags: follow and unfollow */

async function followTag(id) {
    await fetch('/api/tags/follow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

async function unfollowTag(id) {
    await fetch('/api/tags/unfollow', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({id: id})
    });
}

const followTagButtons = document.querySelectorAll('.tag-tooltip-content button');

if (followTagButtons) {
    followTagButtons.forEach((button) => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();
            const id = button.getAttribute('data-id');
            const svg = button.querySelector('svg');
            if (button.classList.contains('follow-tag-button')) {
                await followTag(id);
                svg.nextSibling.textContent = 'Unfollow tag';
            } else {
                await unfollowTag(id);
                svg.nextSibling.textContent = 'Follow tag';
            }
            button.classList.toggle('follow-tag-button');
            button.classList.toggle('unfollow-tag-button');
        });
    });
}

/* Tags: remove from question */

const existingTags = document.querySelectorAll('.all-tags > .all-buttons');
if (existingTags) {
    existingTags.forEach(tag => {
        tag.addEventListener('click', function (event) {
            event.preventDefault();
            const tag = event.target.parentNode;
            tag.remove();
        });
    });
}

/* Votes: questions and answers */

async function requestVote(id, vote, content, type) {
    return await fetch(`/api/${content}/${type}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id, vote: vote})
    });
}

async function voteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content) {
    const voteResponse = await requestVote(id, vote, content, 'vote');
    if (voteResponse.status === 200) {
        voteSVG.classList.replace('unvoted', 'voted');
        voteSVGpath.setAttribute('fill', '#38B6FF');
        if (content === 'questions')
            voteSVG.nextSibling.textContent = ` ${votesNumber + 1}`;
        else
            voteSVG.previousSibling.textContent = `${votesNumber + 1} `;
    } else {
        addError('You cannot vote on your own content');
    }
}

async function unvoteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content) {
    const unvoteResponse = await requestVote(id, vote, content, 'unvote');
    if (unvoteResponse.status === 200) {
        voteSVG.classList.replace('voted', 'unvoted');
        voteSVGpath.setAttribute('fill', '#ABACB1');
        if (content === 'questions')
            voteSVG.nextSibling.textContent = ` ${votesNumber - 1}`;
        else
            voteSVG.previousSibling.textContent = `${votesNumber - 1} `;
    } else {
        addError('Vote could not be removed');
    }
}

async function handleVote(event, element, oppositeSelector, vote, content) {
    event.preventDefault();

    if (!document.querySelector('.my-account-button')) {
        addError('You have to be logged in to vote');
        return;
    }

    const id = element.getAttribute('data-id');
    const votesNumber = parseInt(element.textContent);
    const voteSVG = element.querySelector('svg');
    const voted = voteSVG.classList.contains('voted');
    const voteSVGpath = voteSVG.querySelector('path');

    const oppositeElement = document.querySelector(`${oppositeSelector}[data-id="${id}"]`);
    const oppositeVotesNumber = parseInt(oppositeElement.textContent);
    const oppositeVoteSVG = oppositeElement.querySelector('svg');
    const oppositeVoted = oppositeVoteSVG.classList.contains('voted');
    const oppositeVoteSVGpath = oppositeVoteSVG.querySelector('path');

    if (!voted && !oppositeVoted) {
        // vote
        await voteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content);
    } else if (voted && !oppositeVoted) {
        // remove vote
        await unvoteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content);
    } else if (!voted && oppositeVoted) {
        // swap vote
        await unvoteContent(oppositeVoteSVG, oppositeVoteSVGpath, oppositeVotesNumber, id, !vote, content);
        await voteContent(voteSVG, voteSVGpath, votesNumber, id, vote, content);
    }
}

const questionLikes = document.querySelectorAll('.question-upvotes');
if (questionLikes) {
    questionLikes.forEach((like) => like.addEventListener('click', async (event) => await handleVote(event, like, '.question-downvotes', true, 'questions')));
}

const questionDislikes = document.querySelectorAll('.question-downvotes');
if (questionDislikes) {
    questionDislikes.forEach((dislike) => dislike.addEventListener('click', async (event) => await handleVote(event, dislike, '.question-upvotes', false, 'questions')));
}

const answerLikes = document.querySelectorAll('.answer-upvotes');
if (answerLikes) {
    answerLikes.forEach((like) => like.addEventListener('click', async (event) => await handleVote(event, like, '.answer-downvotes', true, 'answers')));
}

const answerDislikes = document.querySelectorAll('.answer-downvotes');
if (answerDislikes) {
    answerDislikes.forEach((dislike) => dislike.addEventListener('click', async (event) => await handleVote(event, dislike, '.answer-upvotes', false, 'answers')));
}
