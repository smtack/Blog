<?php
require_once "src/init.php";

$page_title = "Blog - Sign Up";

if($_SESSION) {
  header("Location: " . BASE_URL . "/home");
}

if(isset($_POST['signup'])) {
  if(empty($_POST['name']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    $error = "Please fill all fields";
  } else {
    if($_POST['password'] != $_POST['confirm_password']) {
      $error = "Passwords do not match";
    } else {
      $user = new User($db);

      if($user->signUp()) {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->user_username;
        $_SESSION['logged_in'] = true;

        header("Location: " . BASE_URL . "/home");
      } else {
        $error = "Unable to sign up";
      }
    }
  }
}

require VIEW_ROOT . '/index.php';