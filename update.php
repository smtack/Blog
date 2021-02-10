<?php
include_once "src/init.php";

$id = isset($_GET['id']) ? $_GET['id'] : die('Missing ID');

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);

$post->id = $id;

if ($_POST) {
  $post->title = $_POST['title'];
  $post->content = $_POST['content'];
  $post->name = $_POST['name'];

  if ($post->update()) {
    header("Location: home");
  } else {
    echo "Unable to update post";
  }
}

$post->readOne();
?>

<?php require_once "views/includes/header.php"; ?>

<?php require_once "views/includes/navbar.php"; ?>

<div class="content">
  <div class="submit">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id={$id}"); ?>" method="post">
      <ul>
        <li>
          <label for="title">Title</label>
          <input type="text" name="title" value="<?php echo $post->title; ?>"></input>
        </li>
        <li>
          <label for="content">Content</label>
          <textarea name="content"><?php echo $post->content; ?></textarea>
        </li>
        <li>
          <input type="submit" name="submit" value="Post">
        </li>
      </ul>
    </form>
  </div>
</div>

<?php require_once "views/includes/footer.php"; ?>