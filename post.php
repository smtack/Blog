<?php
require_once "src/init.php";

$user = new User($db);
$post = new Post($db);
$comment = new Comment($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

$get_post_data = $post->readSinglePost();
$post_data = $get_post_data->fetch();

if(!$post_data) {
  header("Location: " . BASE_URL . "/home");
}

$page_title = $post_data['post_title'] . " - Blog";

if(isset($_POST['post_comment'])) {
  $comment = new Comment($db);

  if(!$comment->postComment()) {
    echo "Unable to post comment";
  }
}

$get_comments = $comment->getComments();
$comments = $get_comments->fetchAll();

require VIEW_ROOT . "/post.php";