<?php
require_once "public/init.php";

$page_title = "Blog - Log In";

if(isset($_POST['login'])) {
  $user = new User($newDB);

  $user->username = $_POST['username'];

  $checkUser = $user->checkUser();

  if($checkUser && password_verify($_POST['password'], $user->password)) {
    $_SESSION['name'] = $user->name;
    $_SESSION['username'] = $user->username;
    $_SESSION['email'] = $user->email;
    $_SESSION['logged_in'] = true;

    header("Location: " . BASE_URL . "/home.php");
  } else {
    echo "Username or Password Incorrect";
  }
}

require VIEW_ROOT . '/login.php';