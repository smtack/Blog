<?php
require_once "src/init.php";

$user = new User($db);
$post = new Post($db);

$get_user_data = $user->getUserProfile();
$user_data = $get_user_data->fetch();

if(!$user_data) {
  header("Location: " . BASE_URL . "/home");
}

$get_posts = $post->readUsersPosts();
$posts = $get_posts->fetchAll();

$page_title = "Blog - " . $user_data['user_name'] . "'s Profile";

require VIEW_ROOT . "/profile.php";