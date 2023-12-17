var navBarMobile = document.querySelector(".mobile-aside-bar");
var openButton = document.querySelector(".side-bar-icon");
var closeButton = document.querySelector(".close-mobile-bar");

if (closeButton) {

  closeButton.addEventListener("click", function () {
    navBarMobile.classList.toggle("hidden");
  });
}

if (openButton) {
  openButton.addEventListener("click", function () {
    navBarMobile.classList.toggle("hidden");
  });
}