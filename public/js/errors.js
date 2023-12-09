async function checkUsernameOrEmailExists(usernameOrEmail) {
    const url = '/api/users/check-username-email-exists?' + encodeForAjax({
        username_or_email: usernameOrEmail,
    });
    const response = await fetch(url);
    return await response.json();
}

async function checkTagExists(tag) {
    const url = '/api/tags/exist?' + encodeForAjax({
        tag: tag,
    });
    const response = await fetch(url);
    return await response.json();
}

function validateUsernamePattern(username) {
    const regex = /^[a-zA-Z0-9_]+$/; // aceita letras, números e underscore
    return regex.test(username);
}

function validateEmailPattern(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$/; // aceita letras, números, underscore, ponto e hífen
    return regex.test(email);
}

function checkToEnableSubmitButton(error_map) {
    let error = false;
    error_map.forEach((value, key) => {
        if (value) {
            error = true;
        }
    });
    return error;
}

let submitButton = document.querySelector('#submit');
if (!submitButton) submitButton = document.querySelector('.submit');


const error_map = new Map();

document.querySelectorAll('.user-details-input').forEach(async (input) => {
    error_map.set(input.id, false);
    console.log(input.id);
    if (input.id === 'username_or_email') { //login
        input.addEventListener('blur', async () => {
            if (input.value !== '' && (validateUsernamePattern(input.value) || validateEmailPattern(input.value))) {
                await checkUsernameOrEmailExists(input.value).then((response) => {
                    if (response.user === true || response.email === true) {
                        input.style.border = '2px solid green';
                        document.querySelector('.username-or-email-error').style.display = 'none';
                        error_map.set(input.id, false);
                    }
                    else {
                        input.style.border = '2px solid red';
                        document.querySelector('.username-or-email-error').style.display = 'block';
                        error_map.set(input.id, true);
                    }
                });
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);

        });
    }
    else if (input.id === 'username') { //register or user edit
        const initialValue = input.value;
        input.addEventListener('blur', async () => {
            if (input.value !== '') {
                if (!validateUsernamePattern(input.value)) {
                    input.style.border = '2px solid red';
                    document.querySelector('.username-error').textContent = 'Username can only contain letters, numbers and underscores';
                    document.querySelector('.username-error').style.display = 'block';
                    error_map.set(input.id, true);

                }
                else {
                    await checkUsernameOrEmailExists(input.value).then((response) => {
                        if (response.user === false || input.value === initialValue) {
                            input.style.border = '2px solid green';
                            document.querySelector('.username-error').style.display = 'none';
                            error_map.set(input.id, false);
                        }
                        else {
                            input.style.border = '2px solid red';
                            document.querySelector('.username-error').textContent = 'Username is already taken';
                            document.querySelector('.username-error').style.display = 'block';
                            error_map.set(input.id, true);
                        }

                    });
                }
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);

        })
    }
    else if (input.id === 'email') {
        const initialValue = input.value;
        input.addEventListener('blur', async () => {
            if (input.value !== '') {
                if (!validateEmailPattern(input.value)) {
                    input.style.border = '2px solid red';
                    document.querySelector('.email-error').textContent = 'Invalid email format';
                    document.querySelector('.email-error').style.display = 'block';
                    error_map.set(input.id, true);
                }
                else {
                    await checkUsernameOrEmailExists(input.value).then((response) => {
                        if (response.email === false || input.value === initialValue) {
                            input.style.border = '2px solid green';
                            document.querySelector('.email-error').style.display = 'none';
                            error_map.set(input.id, false);
                        }
                        else {
                            input.style.border = '2px solid red';
                            document.querySelector('.email-error').textContent = 'Email is already taken';
                            document.querySelector('.email-error').style.display = 'block';
                            error_map.set(input.id, true);
                        }
                    });
                }
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);
        })
    }
    else if (input.id === 'password') {
        input.addEventListener('input', () => {
            if (input.value !== '') {
                if (input.value.length >= 8) {
                    input.style.border = '2px solid green';
                    document.querySelector('.password-error').style.display = 'none';

                    if (document.querySelector('#password_confirmation')) {
                        if (input.value !== document.querySelector('#password_confirmation').value) {
                            document.querySelector('#password_confirmation').style.border = '2px solid red';
                            document.querySelector('.password-confirmation-error').style.display = 'block';
                            error_map.set('password_confirmation', true);
                        }
                        else {
                            document.querySelector('#password_confirmation').style.border = '2px solid green';
                            document.querySelector('.password-confirmation-error').style.display = 'none';
                            error_map.set('password_confirmation', false);
                        }
                    }

                    error_map.set(input.id, false);
                }
                else {
                    input.style.border = '2px solid red';
                    document.querySelector('.password-error').style.display = 'block';
                    error_map.set(input.id, true);
                }
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);

        })
    }
    else if (input.id === 'password_confirmation') {
        console.log('here');
        input.addEventListener('input', () => {
            if (input.value !== '') {
                if (input.value === document.querySelector('#password').value) {
                    input.style.border = '2px solid green';
                    document.querySelector('.password-confirmation-error').style.display = 'none';
                    error_map.set(input.id, false);
                }
                else {
                    input.style.border = '2px solid red';
                    document.querySelector('.password-confirmation-error').style.display = 'block';
                    error_map.set(input.id, true);
                }
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);

        })
    }
    else if (input.id === 'tag') {
        input.addEventListener('blur', async () => {
            if (input.value !== '') {
                await checkTagExists(input.value).then((response) => {
                    if (response.exists === false) {
                        input.style.border = '2px solid green';
                        document.querySelector('.tag-error').style.display = 'none';
                        error_map.set(input.id, false);
                    }
                    else {
                        input.style.border = '2px solid red';
                        document.querySelector('.tag-error').style.display = 'block';
                        error_map.set(input.id, true);
                    }
                });
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);
        })
    }
});

// this is only for edit profile, which has its own class for the password inputs due to the fact that they are optional
document.querySelectorAll('.edit-password').forEach((input) => {
    error_map.set(input.id, false);
    if (input.id === 'password') {
        input.addEventListener('input', () => {
            if (input.value !== '') {
                if (input.value.length >= 8) {
                    input.style.border = '2px solid green';
                    document.querySelector('.password-error').style.display = 'none';

                    if (document.querySelector('#password_confirmation')) {
                        if (input.value !== document.querySelector('#password_confirmation').value) {
                            document.querySelector('#password_confirmation').style.border = '2px solid red';
                            document.querySelector('.password-confirmation-error').style.display = 'block';
                            error_map.set('password_confirmation', true);
                        }
                        else {
                            document.querySelector('#password_confirmation').style.border = '2px solid green';
                            document.querySelector('.password-confirmation-error').style.display = 'none';
                            error_map.set('password_confirmation', false);
                        }
                    }

                    error_map.set(input.id, false);
                }
                else {
                    input.style.border = '2px solid red';
                    document.querySelector('.password-error').style.display = 'block';
                    error_map.set(input.id, true);
                }
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);
        })
    }
    else if (input.id === 'password_confirmation') {
        console.log('here');
        input.addEventListener('input', () => {
            if (input.value !== '') {
                if (input.value === document.querySelector('#password').value) {
                    input.style.border = '2px solid green';
                    document.querySelector('.password-confirmation-error').style.display = 'none';
                    error_map.set(input.id, false);
                }
                else {
                    input.style.border = '2px solid red';
                    document.querySelector('.password-confirmation-error').style.display = 'block';
                    error_map.set(input.id, true);
                }
            }
            submitButton.disabled = checkToEnableSubmitButton(error_map);
        })
    };
});


