<?php
require_once "src/init.php";

$page_title = "Blog - Log In";

if($_SESSION) {
  header("Location: " . BASE_URL . "/home");
}

if(isset($_POST['login'])) {
  if(empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Enter your Username and Password";
  } else {
    $user = new User($db);

    $logIn = $user->logIn();

    if($logIn && password_verify($_POST['password'], $user->user_password)) {
      $_SESSION['user_id'] = $user->user_id;
      $_SESSION['username'] = $user->user_username;
      $_SESSION['logged_in'] = true;

      header("Location: " . BASE_URL . "/home");
    } else {
      $error = "Username or Password incorrect";
    }
  }
}

require VIEW_ROOT . '/login.php';