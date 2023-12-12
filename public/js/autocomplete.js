let users = [];
let blocked = [];
let unblocked = [];
let tagsAdmin = [];

window.onload = async () => {
    const url = '../../api/users';
    const response = await fetch(url);
    const allUsers = await response.json();
    users = allUsers.map(user => [user.username, user.id]).filter(Boolean);
    blocked = allUsers.filter(user => user.blocked).map(user => [user.username, user.id]);
    unblocked = allUsers.filter(user => !user.blocked).map(user => [user.username, user.id]);

    const urlTags = '../../api/tags';
    const responseTags = await fetch(urlTags);
    const allTags = await responseTags.json();
    tagsAdmin = allTags.map(tag => [tag.name, tag.id]).filter(Boolean);
};

const inputUser = document.querySelector('#user');
if (inputUser) {
    let matchingUsers = [];
    let index = 0;
    
    inputUser.addEventListener('input', function (event) {
        const username = inputUser.value.toUpperCase();
    
        if (username === '') return;

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
    
    inputBlock.addEventListener('input', function (event) {
        const username = inputBlock.value.toUpperCase();
    
        if (username === '') return;

        matchingUsers = unblocked.filter(user => user && user[0].toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputBlock.addEventListener('keydown', async function (event) {
        const user = document.querySelector('#block-user + input');
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
    
    inputUnblock.addEventListener('input', function (event) {
        const username = inputUnblock.value.toUpperCase();
    
        if (username === '') return;

        matchingUsers = blocked.filter(user => user && user[0].toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputUnblock.addEventListener('keydown', async function (event) {
        const user = document.querySelector('#unblock-user + input');
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

        matchingTags = tagsAdmin.filter(tag => tag && tag.toUpperCase().startsWith(tagName)).filter(Boolean);
    });

    questionTags.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                questionTags.value = matchingTags[index];
                index = (index + 1) % matchingTags.length;
            }
        }

    });
}
