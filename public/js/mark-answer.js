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

const answers = document.querySelectorAll('.answer');

if (answers) {
    answers.forEach((answer) => {
        const button = answer.querySelector('.mark');
        if (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const id = button.getAttribute('data-id');
                if (button.classList.contains('mark-correct')) {
                    markAnswer(id);
                    button.textContent = 'Remove correct mark';

                    const path1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path1.setAttribute('fill', '#c8e6c9');
                    path1.setAttribute('d', 'M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z');

                    const path2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path2.setAttribute('fill', '#4caf50');
                    path2.setAttribute('d', 'M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z');

                    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    svg.classList.add('icon-correct');
                    svg.setAttribute('viewBox', '0 0 48 48');
                    svg.setAttribute('width', '40px');
                    svg.setAttribute('height', '40px');

                    svg.appendChild(path1);
                    svg.appendChild(path2);

                    answer.querySelector('header').appendChild(svg);
                } else {
                    deleteMarkAnswer(id);
                    button.textContent = 'Mark as correct';
                    const iconCorrect = answer.querySelector('.icon-correct');
                    iconCorrect.remove();
                }
                button.classList.toggle('mark-correct');
                button.classList.toggle('mark-incorrect');
            });
        }
    });
}
