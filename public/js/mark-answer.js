async function markAnswer(id) {
    await fetch('/api/answers/{id}/correct', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

async function deleteMarkAnswer(id) {
    await fetch('/api/answers/{id}/incorrect', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: encodeForAjax({id: id})
    });
}

const deleteMarkIcons = document.querySelectorAll('.mark-incorrect');
const markIcons = document.querySelectorAll('.mark-correct');
const iconCorrect = document.querySelector('.icon-correct');

markIcons.forEach(icon => {
    icon.addEventListener('click', async function (event) {
        event.preventDefault();
        const id = icon.getAttribute('data-id');
        markAnswer(id);
        icon.classList.add('iconCorrect');   
    });
});   

deleteMarkIcons.forEach(icon => {
    icon.addEventListener('click', async function (event) {
        event.preventDefault();
        const id = icon.getAttribute('data-id');
        deleteMarkAnswer(id);
        icon.classList.remove('iconCorrect'); 
    });
});





