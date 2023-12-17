let users = [];
let blocked = [];
let unblocked = [];
let tagsAdmin = [];

window.onload = async () => {
    const admin = document.querySelector('#admin-page');
    if (admin) {
        const url = '../../api/users';
        const response = await fetch(url);
        const allUsers = await response.json();
        users = allUsers.map(user => [user.username, user.id]).filter(Boolean);
        blocked = allUsers.filter(user => user.blocked).map(user => [user.username, user.id]);
        unblocked = allUsers.filter(user => !user.blocked).map(user => [user.username, user.id]);
    }

    const editQuestion = document.querySelector('#question-edit');
    const createQuestion = document.querySelector('#create-question');
    if (admin || editQuestion || createQuestion) {
        const urlTags = '../../api/tags';
        const responseTags = await fetch(urlTags);
        const allTags = await responseTags.json();
        tagsAdmin = allTags.map(tag => [tag.name, tag.id]).filter(Boolean);
    }
};

const inputUser = document.querySelector('#user');
if (inputUser) {
    let matchingUsers = [];
    let index = 0;
    
    inputUser.addEventListener('input', function (event) {
        const username = inputUser.value.toUpperCase();
    
        if (username === '') return;

        const match = users.find((element) => element[0].toUpperCase() === username);
        if (match) {
            inputUser.setAttribute('value', match[1]);
        } else {
            inputUser.setAttribute('value', '0');
        }

        matchingUsers = users.filter(user => user && user[0].toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputUser.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingUsers.length > 0) {
                index = (index + 1) % matchingUsers.length;
                inputUser.value = matchingUsers[index][0];
                inputUser.setAttribute('value', matchingUsers[index][1]);
            }
        }

    });
}

const inputBlock = document.querySelector('#block-user');
if (inputBlock) {
    let matchingUsers = [];
    let index = 0;

    const user = document.querySelector('#block-user + input');

    inputBlock.addEventListener('input', function (event) {
        const username = inputBlock.value.toUpperCase();
    
        if (username === '') return;

        const match = users.find((element) => element[0].toUpperCase() === username);
        if (match) {
            user.setAttribute('value', match[1]);
        } else {
            user.setAttribute('value', '0');
        }

        matchingUsers = unblocked.filter(user => user && user[0].toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputBlock.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingUsers.length > 0) {
                index = (index + 1) % matchingUsers.length;
                inputBlock.value = matchingUsers[index][0];
                user.value = matchingUsers[index][1];
            }
        }

    });
}

const inputUnblock = document.querySelector('#unblock-user');
if (inputUnblock) {
    let matchingUsers = [];
    let index = 0;

    const user = document.querySelector('#unblock-user + input');

    inputUnblock.addEventListener('input', function (event) {
        const username = inputUnblock.value.toUpperCase();
    
        if (username === '') return;

        const match = users.find((element) => element[0].toUpperCase() === username);
        if (match) {
            user.setAttribute('value', match[1]);
        } else {
            user.setAttribute('value', '0');
        }

        matchingUsers = blocked.filter(user => user && user[0].toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputUnblock.addEventListener('keydown', async function (event) {

        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingUsers.length > 0) {
                index = (index + 1) % matchingUsers.length;
                inputUnblock.value = matchingUsers[index][0];
                inputUnblock.setAttribute('value', matchingUsers[index][1]);
                user.value = matchingUsers[index][1];
            }
        }

    });
}

const inputTags = document.querySelector('#delete-tag');
if (inputTags) {
    let matchingTags = [];
    let index = 0;
    
    inputTags.addEventListener('input', function (event) {
        const tagName = inputTags.value.toUpperCase();
    
        if (tagName === '') return;
    
        matchingTags = tagsAdmin.filter(tag => tag && tag[0].toUpperCase().startsWith(tagName)).filter(Boolean);
    });

    inputTags.addEventListener('keydown', async function (event) {
        const tag = document.querySelector('#delete-tag + input');
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                index = (index + 1) % matchingTags.length;
                inputTags.value = matchingTags[index][0];
                inputTags.setAttribute('value', matchingTags[index][1]);
                tag.value = matchingTags[index][1];
            }
        }

    });
}

const questionTags = document.querySelector('#add-tag');
if (questionTags) {
    let matchingTags = [];
    let index = 0;

    questionTags.addEventListener('input', function (event) {
        const tagName = questionTags.value.toUpperCase();

        if (tagName === '') return;

        matchingTags = tagsAdmin.filter(tag => tag && tag[0].toUpperCase().startsWith(tagName)).filter(Boolean);
    });

    questionTags.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                index = (index + 1) % matchingTags.length;
                questionTags.value = matchingTags[index][0];
            }
        }

    });
}

const tagAskQuestion = document.querySelector('#tag-ask-question');
if (tagAskQuestion) {
    let matchingTags = [];
    let index = 0;

    tagAskQuestion.addEventListener('input', function (event) {
        const tagName = tagAskQuestion.value.toUpperCase();

        if (tagName === '') return;

        matchingTags = tagsAdmin.filter(tag => tag && tag[0].toUpperCase().startsWith(tagName)).filter(Boolean);
    });

    tagAskQuestion.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                index = (index + 1) % matchingTags.length;
                tagAskQuestion.value = matchingTags[index][0];
                tagAskQuestion.setAttribute('value', matchingTags[index][1]);
            }
        }

        if (event.key === 'Enter') {
            event.preventDefault();
            const tagName = tagAskQuestion.value;
            const tagId = tagAskQuestion.getAttribute('value');

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

            tagAskQuestion.value = "";
            }
        }
    );
}
