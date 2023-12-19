function toggle(element) {
    if (element.style.display === 'none' || !element.style.display) {
        element.style.display = 'flex';
    } else {
        element.style.display = 'none';
    }
}

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
