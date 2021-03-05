<?php
require_once "public/init.php";

if(!$_SESSION['logged_in']) {
  header("Location: " . BASE_URL . "/index");
}

$page_title = "Blog";

$user = new User($newDB);
$post = new Post($newDB);

$get_user_data = $user->getSingleUser();
$user_data = $get_user_data->fetch();

if(isset($_POST['submit_post']) && !empty($_FILES['image']['name'])) {
  if(empty($_POST['title']) || empty($_POST['content'])) {
    echo "Enter a title and some text.";
  } else {
    $target_dir = "uploads/";
    $file_name = basename($_FILES['image']['name']);
    $path = $target_dir . $file_name;
    $file_type = pathinfo($path, PATHINFO_EXTENSION);
    $allow_types = array('jpg', 'png', 'jpeg', 'gif');

    if(in_array($file_type, $allow_types)) {
      if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        $post->name = $user_data['name'];
        $post->username = $user_data['username'];
        $post->title = $_POST['title'];
        $post->image = $file_name;
        $post->content = $_POST['content'];
      
        if(!$post->createPost()) {
          echo "Unable to submit post.";
        }
      }
    } else {
      echo "Image type is not supported.";
    }
  }
} else if(isset($_POST['submit_post'])) {
  if(empty($_POST['title']) || empty($_POST['content'])) {
    echo "Enter a title and some text.";
  } else {
    $post->name = $user_data['name'];
    $post->username = $user_data['username'];
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];

    if(!$post->createPost()) {
      echo "Unable to submit post.";
    }
  }
}

$post->username = $user_data['username'];
$get_posts = $post->readPosts();
$posts = $get_posts->fetchAll();

require VIEW_ROOT . '/home.php';