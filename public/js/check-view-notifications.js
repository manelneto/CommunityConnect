async function readNotification(id) {
    await fetch('/api/notifications/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const viewIcons = document.querySelectorAll('.view-icon');
const notificationsNumber = document.querySelector('.notifications-number');

if (viewIcons) {
    viewIcons.forEach((viewIcon) => {
        viewIcon.addEventListener('click', async (event) => {
            event.preventDefault();
            const id = viewIcon.id;
            viewIcon.previousElementSibling.remove();
            viewIcon.remove();
            notificationsNumber.textContent = `${parseInt(notificationsNumber.textContent) - 1}`;
            await readNotification(id);
        });
        
        viewIcon.addEventListener('mouseover', (event) => {
            event.preventDefault();
            viewIcon.previousElementSibling.style.display = 'block';
        });

        viewIcon.addEventListener('mouseout', (event) => {
            event.preventDefault();
            viewIcon.previousElementSibling.style.display = 'none';
        });
    });
}
