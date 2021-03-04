<?php
require_once "public/init.php";

if(!$_SESSION['logged_in']) {
  header("Location: " . BASE_URL . "/index.php");
}

$page_title = "Blog - Update Profile";

$user = new User($newDB);

$id = isset($_GET['id']) ? $_GET['id'] : die("No ID");

$get_user_data = $user->getSingleUser();
$user_data = $get_user_data->fetch();

$user->id = $id;

if(isset($_POST['update'])) {
  $user->name = $_POST['name'];
  $user->username = $_POST['username'];
  $user->email = $_POST['email'];

  if($user->updateUser()) {
    header("Location: " . BASE_URL . "/home.php");
  } else {
    echo "Unable to update profile.";
  }
}

if(isset($_POST['change_password'])) {
  $confirm_password = $_POST['confirm_password'];
  $user->password = $_POST['new_password'];

  if(password_verify($confirm_password, $user_data['password'])) {
    if($user->changePassword()) {
      header("Location: home.php");
    } else {
      echo "Could not change password.";
    }
  } else {
    echo("<p>Enter your current password correctly</p>");
  }
}

require VIEW_ROOT . '/update.php';