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

channel.bind('commentQuestion', function(notification) {
  if (getUserId() === notification.id_user) {
    const article = document.createElement('article');
    article.classList.add('notification');

    const h3 = document.createElement('h3');
    h3.innerHTML = 'New comment on your question';

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

channel.bind('commentQuestion', function(notification) {
  if (getUserId() === notification.id_user) {
    const article = document.createElement('article');
    article.classList.add('notification');

    const h3 = document.createElement('h3');
    h3.innerHTML = 'New comment on your question';

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