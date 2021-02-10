<?php
include_once "src/init.php";

$id = isset($_GET['id']) ? $_GET['id'] : die('Missing ID');

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);

$post->id = $id;

if ($post->delete()) {
  header("Location: home");
} else {
  echo "Unable to delete post";
}