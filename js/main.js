var signupForm = document.querySelector('#signup');
var loginForm = document.querySelector('#login');
var signupButton = document.querySelector('#signupButton');
var loginButton = document.querySelector('#loginButton');

window.onload = function() {
  signupButton.style.backgroundColor = "#000000";
  signupButton.style.color = "#ffffff";
  loginButton.style.backgroundColor = "#ffffff";
  loginButton.style.color = "#000000";
  loginForm.style.display = "none";
}

signupButton.addEventListener("click", function() {
  signupButton.style.backgroundColor = "#000000";
  signupButton.style.color = "#ffffff";
  loginButton.style.backgroundColor = "#ffffff";
  loginButton.style.color = "#000000";
  loginForm.style.display = "none";
  signupForm.style.display = "block";
});

loginButton.addEventListener("click", function() {
  signupButton.style.backgroundColor = "#ffffff";
  signupButton.style.color = "#000000";
  loginButton.style.backgroundColor = "#000000";
  loginButton.style.color = "#ffffff";
  loginForm.style.display = "block";
  signupForm.style.display = "none";
});