const findButton = document.getElementById('find-user');

if (findButton) {
    findButton.addEventListener('click', (event) => {
        event.preventDefault();
        const selectElement = document.getElementById('username');
        const id = selectElement.value;
        const url = `../../users/${id}`;
        window.location.href = url;
    });
}
