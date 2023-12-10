function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send(encodeForAjax(data));
}

function show(element) {
  element.style.display = 'initial';
}

function hide(element) {
  element.style.display = 'none';
}

function toggle(element) {
  if (element.style.display === 'none' || !element.style.display) {
    element.style.display = 'flex';
  } else {
    hide(element);
  }
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
