<?php
include_once "src/init.php";

$id = isset($_GET['id']) ? $_GET['id'] : die("Missing ID");

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);
$post->id = $id;

$post->readOne();
?>

<?php require_once "views/includes/header.php"; ?>

<?php require_once "views/includes/navbar.php"; ?>

<div class="content">
  <div class="post-content">
    <h2><?php echo $post->title; ?></h2>

    <p class="datetime"><?php echo $post->datetime; ?></p>
    <p class="name"><?php echo $post->name; ?>

    <p class="content"><?php echo $post->content; ?></p>
  </div>
</div>

<?php require_once "views/includes/footer.php"; ?>