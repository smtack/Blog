<?php
require_once "public/init.php";

$post = new Post($newDB);

$id = isset($_GET['id']) ? $_GET['id'] : die("No ID");

$post->id = $id;

$get_post_data = $post->readSinglePost();
$post_data = $get_post_data->fetch();

$path = "uploads/";
$image = $post_data['image'];
$file_name = $path . $image;

if($post->deletePost()) {
  if(file_exists($file_name)) {
    unlink($file_name);
  }
  
  header("Location: " . BASE_URL . "/home.php");
} else {
  echo "Unable to delete post.";
}