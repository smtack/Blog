<?php
require_once "public/init.php";

$user = new User($newDB);
$post = new Post($newDB);

$id = isset($_GET['id']) ? $_GET['id'] : header("Location: " . BASE_URL . "/home");

$get_user_data = $user->getUserProfile();
$user_data = $get_user_data->fetch();

if(!$user_data) {
  header("Location: " . BASE_URL . "/home");
}

$post->username = $user_data['username'];
$get_posts = $post->readPosts();
$posts = $get_posts->fetchAll();

$page_title = "Blog - " . $user_data['name'] . "'s Profile";

require VIEW_ROOT . "/profile.php";