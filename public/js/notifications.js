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

function addNotification(title, notification) {
    const article = document.createElement('article');
    article.classList.add('notification');

    const h3 = document.createElement('h3');
    h3.innerHTML = title;

    const a = document.createElement('a');
    a.href = `/questions/${notification.id_question}`;
    a.innerHTML = notification.message;

    article.appendChild(h3);
    article.appendChild(a);

    const notifications = document.getElementById('notifications');
    notifications.appendChild(article);

    window.setTimeout(() => document.getElementById('notifications').firstElementChild.remove(), 15000);
}

const channel = pusher.subscribe('CommunityConnect');

channel.bind('answer', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New answer', notification);
    }
});

channel.bind('commentQuestion', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New comment on your question', notification);
    }
});

channel.bind('commentAnswer', function (notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New comment on your answer', notification);
    }
});

channel.bind('voteQuestion', function(notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New vote on your question', notification);
    }
});

channel.bind('voteAnswer', function(notification) {
    if (getUserId() === notification.id_user) {
        addNotification('New vote on your answer', notification);
    }
});
