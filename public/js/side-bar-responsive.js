const navBarMobile = document.querySelector('.mobile-aside-bar');
const openButton = document.querySelector('.side-bar-icon');
const closeButton = document.querySelector('.close-mobile-bar');

if (closeButton && navBarMobile) {
    closeButton.addEventListener('click', function () {
        navBarMobile.classList.toggle('nav-bar-hidden');
    });
}

if (openButton && navBarMobile) {
    openButton.addEventListener('click', function () {
        navBarMobile.classList.toggle('nav-bar-hidden');
        navBarMobile.style.visibility = 'visible';
        navBarMobile.style.opacity = '1';
    });
}
