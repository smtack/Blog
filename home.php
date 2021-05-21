<?php
require_once "src/init.php";

if(!$_SESSION['logged_in']) {
  header("Location: " . BASE_URL);
}

$page_title = "Blog";

$user = new User($db);
$post = new Post($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

$get_posts = $post->readPosts();
$posts = $get_posts->fetchAll();

require VIEW_ROOT . '/home.php';