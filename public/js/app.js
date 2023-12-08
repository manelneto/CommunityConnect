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
  console.log(element.style.display);
  if (element.style.display === 'none' || !element.style.display) {
    element.style.display = 'flex';
  } else {
    hide(element);
  }
}

const pusher = new Pusher("96d60c26f4314399aa8b", {
  cluster: "eu",
  encrypted: true
});

function getUserId() {
  const link = document.querySelector('.my-account-button');
  if (link) {
    return link.href.split('/').pop();
  }
}

const channel = pusher.subscribe('CommunityConnect');
channel.bind('answer', function(notification) {
  if (getUserId() === notification.id_user) {
    const article = document.createElement('article');
    article.classList.add('notification');

    const h3 = document.createElement('h3');
    h3.innerHTML = 'New answer';

    const p = document.createElement('p');
    p.innerHTML = notification.message;
    
    const a = document.createElement('a');
    a.href = `/questions/${notification.id_question}`;
    a.innerHTML = 'Here';

    article.appendChild(h3);
    article.appendChild(p);
    article.appendChild(a);

    const notifications = document.getElementById('notifications');
    notifications.appendChild(article);
  }
});
