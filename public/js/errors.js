async function validateUsernameOrEmail(usernameOrEmail) {
    const url = '/api/users/validate-username-or-email?' + encodeForAjax({ 
        username_or_email: usernameOrEmail,
    });
    const response = await fetch(url);
    return await response.json();
}

document.querySelectorAll('.user-details-input').forEach(async (input) => {
    input.addEventListener('input', () => {
        if (input.id === 'username_or_email') { //login
            if (input.value !== '') {
                validateUsernameOrEmail(input.value).then((response) => {
                    if (response.user === true || response.email === true){
                        input.style.border = '2px solid green';
                        document.querySelector('.username-or-email-error').style.display = 'none';
                    }     
                    else{
                        input.style.border = '2px solid red';
                        document.querySelector('.username-or-email-error').style.display = 'block';
                    } 
                        
                });
            }
        }
        else if (input.id === 'username') { //register
            if (input.value !== '') {

                validateUsernameOrEmail(input.value).then((response) => {
                    if (response.user === false){
                        input.style.border = '2px solid green';
                        document.querySelector('.username-error').style.display = 'none';
                    }     
                    else{
                        input.style.border = '2px solid red';
                        document.querySelector('.username-error').style.display = 'block';
                    } 
                });
            }
        }
        else if (input.id === 'email') {
            if (input.value !== '') {
                validateUsernameOrEmail(input.value).then((response) => {
                    if (response.email === false){
                        input.style.border = '2px solid green';
                        document.querySelector('.email-error').style.display = 'none';
                    }     
                    else{
                        input.style.border = '2px solid red';
                        document.querySelector('.email-error').style.display = 'block';
                    } 
                });
            }
        }
        else if (input.id === 'password') {
            if (input.value !== '') {
                if (input.value.length >= 8){
                    input.style.border = '2px solid green';
                    document.querySelector('.password-error').style.display = 'none';
                }     
                else{
                    input.style.border = '2px solid red';
                    document.querySelector('.password-error').style.display = 'block';
                } 
            }
        }
        else if (input.id === 'password_confirmation') {
            if (input.value !== '') {
                if (input.value === document.querySelector('#password').value){
                    input.style.border = '2px solid green';
                    document.querySelector('.password-confirmation-error').style.display = 'none';
                }     
                else{
                    input.style.border = '2px solid red';
                    document.querySelector('.password-confirmation-error').style.display = 'block';
                } 
            }
        }
    });
});
