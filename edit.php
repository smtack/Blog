<?php
require_once "src/init.php";

$user = new User($db);
$post = new Post($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

$get_post_data = $post->readSinglePost();
$post_data = $get_post_data->fetch();

if(isset($_POST['update_post']) && !empty($_FILES['image']['name'])) {
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
      
        if($post->updatePost()) {
          header("Location: " . BASE_URL . "/home");
        } else {
          $error = "Unable to update post";
        }
      }
    } else {
      $error = "Image type is not supported";
    }
  }
} else if(isset($_POST['update_post'])) {
  if(empty($_POST['title']) || empty($_POST['content'])) {
    $error = "Enter a title and some text";
  } else {
    if($post->updatePost()) {
      header("Location: " . BASE_URL . "/home");
    } else {
      $error = "Unable to update post";
    }
  }
}

if(isset($_POST['delete'])) {
  $delete_path = "uploads/";
  $image_to_delete = $post_data['post_image'];
  $file_to_delete = $delete_path . $image_to_delete;

  if($post->deletePost()) {
    if(file_exists($file_to_delete)) {
      unlink($file_to_delete);
    }

    header('Location: ' . BASE_URL . '/home');
  } else {
    $error = "Unable to delete post";
  }
}

$page_title = "Edit Post: " . $post_data['post_title'] . " - Blog";

require VIEW_ROOT . "/edit.php";