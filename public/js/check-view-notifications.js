async function checkVisualizationNotifications(id) {
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
const numberNots = document.querySelector('.notifications-number');

if (viewIcons) {
    viewIcons.forEach((viewIcon) => {
        viewIcon.addEventListener('click', (event) => {
            event.preventDefault();
            const id = viewIcon.id;
            viewIcon.remove();
            numberNots.textContent = parseInt(numberNots.textContent) - 1;
            checkVisualizationNotifications(id);
        });
        
        viewIcon.addEventListener('mouseover', (event) => {
            event.preventDefault();
            viewIcon.nextElementSibling.style.display = 'flex';
        });

        viewIcon.addEventListener('mouseout', (event) => {
            event.preventDefault();
            viewIcon.nextElementSibling.style.display = 'none';
        });
    });
}
