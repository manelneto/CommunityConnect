let users = Array();
let blocked = Array();
let unblocked = Array();
let tags = Array();

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

window.onload = async () => {
    const admin = document.querySelector('#admin-page');
    if (admin) {
        const url = '../../api/users';
        const response = await fetch(url);
        const allUsers = await response.json();
        users = allUsers.map(user => [user.username, user.id]).filter(Boolean).sort((a, b) => (a[0].localeCompare(b[0])));
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
