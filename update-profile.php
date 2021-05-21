<?php
require_once "src/init.php";

if(!$_SESSION['logged_in']) {
  header("Location: " . BASE_URL . "/index");
}

$page_title = "Blog - Update Profile";

$user = new User($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

if($_GET['id'] != $user_data['user_id']) {
  header("Location: " . BASE_URL . "/home");
}

if(isset($_POST['submit-profile-picture'])) {
  if(empty($_FILES['profile-picture']['name'])) {
    $error = "Upload a picture";
  } else {
    $target_dir = "uploads/profile-pictures/";
    $file_name = basename($_FILES['profile-picture']['name']);
    $path = $target_dir . $file_name;
    $file_type = pathinfo($path, PATHINFO_EXTENSION);
    $allow_types = array('jpg', 'png', 'PNG', 'jpeg', 'gif');
  
    if(in_array($file_type, $allow_types)) {
      if(move_uploaded_file($_FILES['profile-picture']['tmp_name'], $path)) {
        $user->user_profile_picture = $file_name;
  
        if($user->updateProfilePicture()) {
          header("Location: " . BASE_URL . "/home");
        } else {
          $error = "Unable to update profile picture";
        }
      }
    } else {
      $error = "Image type is not supported";
    }
  }
}

if(isset($_POST['update'])) {
  if(empty($_POST['name']) || empty($_POST['email'])) {
    $info_error = "Fill in all fields";
  } else {
    if($user->updateUser()) {
      header("Location: " . BASE_URL . "/home");
    } else {
      $info_error = "Unable to update profile";
    }
  }
}

if(isset($_POST['change_password'])) {
  if(empty($_POST['confirm_password']) || empty($_POST['new_password']) || empty($_POST['confirm_new_password'])) {
    $password_error = "Fill in all fields";
  } else {
    if($_POST['new_password'] != $_POST['confirm_new_password']) {
      $password_error = "Passwords do not match";
    } else {
      $confirm_password = $_POST['confirm_password'];

      if(password_verify($confirm_password, $user_data['user_password'])) {
        if($user->changePassword()) {
          header("Location: " . BASE_URL . "/home");
        } else {
          $password_error = "Could not change password";
        }
      } else {
        $password_error = "Enter your current password correctly";
      }
    }
  }
}

if(isset($_POST['delete-profile'])) {
  if($user->deleteUser()) {
    $user->logOut();

    header('Location: ' . BASE_URL);
  } else {
    $delete_error = "Unable to delete user";
  }
}

require VIEW_ROOT . '/update-profile.php';