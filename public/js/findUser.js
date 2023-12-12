const findButton = document.getElementById('find-user');

if (findButton) {
    findButton.addEventListener('click', (event) => {
        event.preventDefault();
        const user = document.getElementById('user');
        const id = user.getAttribute('value');
        window.location.href = `../../users/${id}`;
    });
}
