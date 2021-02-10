<?php
include_once "src/init.php";

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);

$stmt = $post->read();
?>

<?php require_once "views/includes/header.php"; ?>

<?php require_once "views/includes/navbar.php"; ?>

<div class="content">
  <div class="posts">
    <?php
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $content = substr($content, 0, 140);

        echo("
          <div class='post'>
            <h2 class='title'><a href='post?id={$id}'>{$title}</a></h2>
            <p class='content'>{$content}</p>
            <p class='datetime'>{$datetime}</p>
            <p class='name'>{$name}</p>
        ");

        if ($_SESSION['loggedIn'] == true) {
          echo("<p class='options'><a href='update?id={$id}'>Update</a><a href='delete.php?id={$id}'>Delete</a></p>");
        }

        echo ("</div>");
      }
    ?>
  </div>
</div>

<?php require_once "views/includes/footer.php"; ?>