const button = document.querySelector('#edit-password');

if (button) {
    button.addEventListener('click', function(event) {
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
