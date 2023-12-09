let users = [];
let blocked = [];
let unblocked = [];

window.onload = async () => {
    const url = '../api/users';
    const response = await fetch(url);
    const allUsers = await response.json();
    users = allUsers.map(user => user.username).filter(Boolean);
    blocked = allUsers.map(user => user.username).filter(user => user.blocked);
    unblocked = allUsers.map(user => user.username).filter(user => !user.blocked);
};

const inputUser = document.querySelector('#user');
if (inputUser) {
    let matchingTags = [];
    let index = 0;
    
    inputUser.addEventListener('input', function (event) {
        const username = inputUser.value.toUpperCase();
    
        if (username === '') return;
    
        matchingTags = users.filter(user => user && user.toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputUser.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                inputUser.value = matchingTags[index];
                index = (index + 1) % matchingTags.length;
            }
        }

    });
}

const inputBlock = document.querySelector('#block-user');
if (inputBlock) {
    let matchingTags = [];
    let index = 0;
    
    inputBlock.addEventListener('input', function (event) {
        const username = inputBlock.value.toUpperCase();
    
        if (username === '') return;
    
        matchingTags = unblocked.filter(user => user && user.toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputBlock.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                inputBlock.value = matchingTags[index];
                index = (index + 1) % matchingTags.length;
            }
        }

    });
}

const inputUnblock = document.querySelector('#unblock-user');
if (inputUnblock) {
    let matchingTags = [];
    let index = 0;
    
    inputUnblock.addEventListener('input', function (event) {
        const username = inputUnblock.value.toUpperCase();
    
        if (username === '') return;
    
        matchingTags = blocked.filter(user => user && user.toUpperCase().startsWith(username)).filter(Boolean);
    });

    inputUnblock.addEventListener('keydown', async function (event) {
        if (event.key === 'Tab') {
            event.preventDefault();
            if (matchingTags.length > 0) {
                inputUnblock.value = matchingTags[index];
                index = (index + 1) % matchingTags.length;
            }
        }

    });
}