const editAnswers = document.querySelectorAll('.answer');

if (editAnswers) {
    editAnswers.forEach((answer) => {
        const button = answer.querySelector('.edit');
        if (button) {
            const id = button.getAttribute('data-id');
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const file = answer.querySelector('.file');
                if (file) {
                    file.remove();
                }

                const paragraphs= answer.querySelectorAll('.answer .description');
                const array = Array();
                paragraphs.forEach((paragraph) => {
                    array.push(paragraph.textContent);
                    paragraph.remove();
                });
                const description = array.join('');

                const label1 = document.createElement('label');
                label1.setAttribute('for', `content-${id}`);
                label1.classList.add('label-content');
                label1.textContent = 'Content';

                const textarea = document.createElement('textarea');
                textarea.id = `content-${id}`;
                textarea.classList.add('description');
                textarea.classList.add('non-movable-textarea');
                textarea.name = 'content';
                textarea.cols = 40;
                textarea.rows = 4;
                textarea.placeholder = 'Type in your answer here';
                textarea.value = description;

                const label2 = document.createElement('label');
                label2.setAttribute('for', `file-${id}`);
                label2.classList.add('label-file');
                label2.textContent = 'File';

                const input = document.createElement('input');
                input.id = `content-${id}`;
                input.type = 'file';
                input.name = 'file';
                input.accept = 'image/png,image/jpg,image/jpeg,application/doc,application/pdf,application/txt';

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'type';
                hidden.value = 'answer';

                const form = answer.querySelector('form');
                const buttons = form.querySelector('.answer-buttons');
                form.insertBefore(label1, buttons);
                form.insertBefore(textarea, buttons);
                form.insertBefore(label2, buttons);
                form.insertBefore(input, buttons);
                form.insertBefore(hidden, buttons);

                const save = document.createElement('button');
                save.classList.add('edit');
                save.formAction = `../../answers/${id}`;
                save.textContent = 'Save';

                buttons.insertBefore(save, button);
                button.remove();
            });
        }
    });
}
