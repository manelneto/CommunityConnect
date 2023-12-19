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
