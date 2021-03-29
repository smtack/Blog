<?php
require_once "public/init.php";

$id = isset($_GET['id']) ? $_GET['id'] : header("Location: home");

$post = new Post($newDB);

$post->id = $id;
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
    $allow_types = array('jpg', 'png', 'jpeg', 'gif');
  
    if(in_array($file_type, $allow_types)) {
      if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        $post->title = $_POST['title'];
        $post->image = $file_name;
        $post->content = $_POST['content'];
      
        if(!$post->updatePost()) {
          $error = "Unable to update post";
        } else {
          header("Location: home");
        }
      }
    }
  }
} else if(isset($_POST['update_post'])) {
  if(empty($_POST['title']) || empty($_POST['content'])) {
    $error = "Enter a title and some text";
  } else {
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
  
    if(!$post->updatePost()) {
      $error = "Unable to update post";
    } else {
      header("Location: home");
    }
  }
}

$page_title = $post_data['title'] . " - Update Post - Blog";

require VIEW_ROOT . "/update_post.php";