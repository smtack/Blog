<?php
include_once "src/init.php";

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);

if ($_POST) {
  $post->title = $_POST['title'];
  $post->content = $_POST['content'];
  $post->name = $_SESSION['name'];
  $post->email = $_SESSION['email'];

  if ($post->create()) {
    header('Location: home');
  } else {
    echo "Unable to create post";
  }
}

$stmt = $post->read();
?>

<?php require_once "views/includes/header.php"; ?>

<?php require_once "views/includes/navbar.php"; ?>

<div class="content">
  <div class="submit">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <ul>
        <li>
          <label for="title">Title</label>
          <input type="text" name="title"></input>
        </li>
        <li>
          <label for="content">Content</label>
          <textarea name="content"></textarea>
        </li>
        <li>
          <input type="submit" name="submit" value="Post">
        </li>
      </ul>
    </form>
  </div>
</div>

<?php require_once "views/includes/footer.php"; ?>