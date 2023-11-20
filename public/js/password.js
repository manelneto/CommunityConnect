const button = document.querySelector('#edit-password');

if (button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const fields = document.querySelectorAll('.edit-password');
        if (fields) {
            fields.forEach((field) => {
                field.style.display = (field.style.display === 'none' || field.style.display === '' ? 'block' : 'none')
                field.value = '';
            });
        }
    });
}
