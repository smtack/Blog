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

$post->username = $user_data['username'];
$get_posts = $post->readPosts();
$posts = $get_posts->fetchAll();

require VIEW_ROOT . '/home.php';