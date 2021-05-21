<?php
require_once "src/init.php";

if(!$_SESSION['logged_in']) {
  header("Location: " . BASE_URL . "/index");
}

$page_title = "Blog - Create Post";

$user = new User($db);
$post = new Post($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

if(isset($_POST['submit_post']) && !empty($_FILES['image']['name'])) {
  if(empty($_POST['title']) || empty($_POST['content'])) {
    $error = "Enter a title and some text";
  } else {
    $target_dir = "uploads/";
    $file_name = basename($_FILES['image']['name']);
    $path = $target_dir . $file_name;
    $file_type = pathinfo($path, PATHINFO_EXTENSION);
    $allow_types = array('jpg', 'png', 'PNG', 'jpeg', 'gif');

    if(in_array($file_type, $allow_types)) {
      if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        $post->post_image = $file_name;
      
        if($post->createPost()) {
          header("Location: " . BASE_URL . "/home");
        } else {
          $error = "Unable to submit post";
        }
      }
    } else {
      $error = "Image type is not supported";
    }
  }
} else if(isset($_POST['submit_post'])) {
  if(empty($_POST['title']) || empty($_POST['content'])) {
    $error = "Enter a title and some text";
  } else {
    if($post->createPost()) {
      header("Location: " . BASE_URL . "/home");
    } else {
      $error = "Unable to submit post";
    }
  }
}

require VIEW_ROOT . "/create.php";