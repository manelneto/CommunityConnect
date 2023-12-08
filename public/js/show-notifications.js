const notificationIcon = document.querySelectorAll(".notifications-icon");

if (notificationIcon) {
    notificationIcon.addEventListener("click", (event) => {
      event.preventDefault();
        showNotifications();
    }
    );
}

function showNotifications() {
    const notifications = document.querySelector(".notifications");
    notifications.classList.toggle("show-notifications");
}

