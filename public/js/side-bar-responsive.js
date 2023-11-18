window.onload = function () {
  // Selecting the mobile navigation bar
  var navBarMobile = document.querySelector(".mobile-aside-bar");

  // Selecting the icon to open the nav bar
  var openButton = document.querySelector(".side-bar-icon");

  // Adding click event listener to the element with class "close-mobile-app"
  var closeButton = document.querySelector(".close-mobile-bar");

  if (closeButton) {
    // Check if the element exists
    closeButton.addEventListener("click", function () {
      // Toggling the 'hidden' class to show/hide the nav bar
      navBarMobile.classList.toggle("hidden");
    });
  }

  if (openButton) {
    openButton.addEventListener("click", function () {
      navBarMobile.classList.toggle("hidden");
    });
  }
};
