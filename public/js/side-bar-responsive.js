var navBarMobile = document.querySelector(".mobile-aside-bar");
var openButton = document.querySelector(".side-bar-icon");
var closeButton = document.querySelector(".close-mobile-bar");

if (closeButton) {

  closeButton.addEventListener("click", function () {
    navBarMobile.classList.toggle("nav-bar-hidden");
  });
}

if (openButton) {
  openButton.addEventListener("click", function () {
    navBarMobile.classList.toggle("nav-bar-hidden");
    navBarMobile.style.visibility = 'visible';
    navBarMobile.style.opacity = '1';
  });
}