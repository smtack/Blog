<?php
include_once "src/init.php";

$database = new Database();
$newDB = $database->DB();

$user = new User($newDB);

$stmt = $user->readUsers();
?>

<?php require_once "views/includes/header.php"; ?>

<?php require_once "views/includes/navbar.php"; ?>

<div class="content">
  <div class="posts">
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      echo("
        <div class='post'>
          <h3 class='title'><a href='profile?username={$username}'>{$name}</a></h3>
      ");

      echo ("</div>");
    }
    ?>
  </div>
</div>

<?php require_once "views/includes/footer.php"; ?>