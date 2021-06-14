const indexForms = document.querySelector('.index-forms');

const signupButton = document.querySelector('.signup-button');
const loginButton = document.querySelector('.login-button');
const signupForm = document.querySelector('.signup-form');
const loginForm = document.querySelector('.login-form');

const nav = document.querySelector('.nav');
const menuButton = document.querySelector('.menu-button');

window.onload = () => {
  if(indexForms) {
    loginForm.style.display = "none";
    signupButton.style.backgroundColor = "#ffffff";
    signupButton.style.color = "#000000";
  }

  if(nav) {
    nav.style.display = "none";
  }
}

if(indexForms) {
  loginButton.addEventListener("click", () => {
    loginForm.style.display = "block";
    signupForm.style.display = "none";
    signupButton.style.backgroundColor = "#000000";
    signupButton.style.color = "#ffffff";
    loginButton.style.backgroundColor = "#ffffff";
    loginButton.style.color = "#000000";
  });
}

if(indexForms) {
  signupButton.addEventListener("click", () => {
    loginForm.style.display = "none";
    signupForm.style.display = "block";
    signupButton.style.backgroundColor = "#ffffff";
    signupButton.style.color = "#000000";
    loginButton.style.backgroundColor = "#000000";
    loginButton.style.color = "#ffffff";
  });
}

if(nav) {
  menuButton.addEventListener("click", () => {
    if(nav.style.display == "none") {
      nav.style.display = "block";
    } else {
      nav.style.display = "none";
    }
  });
}