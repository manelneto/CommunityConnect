function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function addError(text) {
    if (document.querySelector('.error-box')) {
        const list = document.querySelector('.error-box ul');

        const error = document.createElement('li');
        error.textContent = text;

        list.appendChild(error);
    } else {
        const errorBox = document.createElement('section');
        errorBox.classList.add('error-box');

        const title = document.createElement('h2');
        title.textContent = 'Errors';

        const list = document.createElement('ul');

        const error = document.createElement('li');
        error.textContent = text;

        list.appendChild(error);
        errorBox.appendChild(list);
        errorBox.appendChild(title);

        document.querySelector('main').appendChild(errorBox);
    }
}
