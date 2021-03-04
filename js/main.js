const searchButton = document.querySelector('.search-button');
const search = document.querySelector('.search');

const menuButton = document.querySelector('.menu-button');
const menu = document.querySelector('.menu');

searchButton.addEventListener("click", () => {
  if(search.style.display === "none") {
    search.style.display = "block";
  } else {
    search.style.display = "none";
  }
});

menuButton.addEventListener("click", () => {
  if(menu.style.display == "none") {
    menu.style.display = "block";
  } else {
    menu.style.display = "none";
  }
});