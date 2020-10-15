<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('Missing ID');

include_once "php/Database.php";
include_once "php/Post.php";

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);

$post->id = $id;

if ($post->delete()) {
  header("Location: home.php");
} else {
  echo "Unable to delete post";
}
?>
