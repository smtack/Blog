<?php
require_once "public/init.php";

$id = isset($_GET['id']) ? $_GET['id'] : header("Location: home.php");

$post = new Post($newDB);

$post->id = $id;
$get_post_data = $post->readSinglePost();
$post_data = $get_post_data->fetch();

$page_title = $post_data['title'] . " - Blog";

require VIEW_ROOT . "/post.php";