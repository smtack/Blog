var menuButton = document.querySelector('#menu-button');
var menu = document.querySelector('#menu');
var viewportWidth = window.innerWidth || document.documentElement.ClientWidth;

window.addEventListener("resize", function() {
  if (viewportWidth > 750) {
    menu.style.display = "block";
  }
}, false);

menuButton.addEventListener("click", function() {
  if (menu.style.display == "none") {
    menu.style.display = "block";
  } else {
    menu.style.display = "none";
  }
});