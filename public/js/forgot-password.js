const forgotPassword = document.querySelector('#forgot-password');

if (forgotPassword) {
    forgotPassword.addEventListener('click', (event) => {
       event.preventDefault();
       forgotPassword.remove();
       document.querySelector('#password-group').remove();
       document.querySelector('#remember-me-group').remove();
       document.querySelector('.sign-page-right-content button').textContent = 'Send Email';
       document.querySelector('.sign-page-right-content').action = "../mail"
    });
}
