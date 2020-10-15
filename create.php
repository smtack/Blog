<?php
include_once "php/Database.php";
include_once "php/Post.php";
include_once "php/User.php";
include_once "php/core.php";

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);

if ($_POST) {
  $post->title = $_POST['title'];
  $post->content = $_POST['content'];
  $post->name = $_SESSION['name'];
  $post->email = $_SESSION['email'];

  if ($post->create()) {
    header('Location: home.php');
  } else {
    echo "Unable to create post";
  }
}

$stmt = $post->read();
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="css/main.css" rel="stylesheet">

  <title>Blog - Create</title>
</head>
<body>
  <div class="header">
    <h1><a href="home.php">Blog</a></h1>

    <span id="menu-button"><img src="img/menu.png"></span>

    <div id="menu">
      <ul>
        <li>
          <div class="search">
            <form action="search.php" method="get">
              <input type="text" name="s" placeholder="Search"></input>
            </form>
          </div>
        </li>
        <li><a href="profile.php?username=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a></li>
        <li><a href="create.php">Create</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>

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

  <div class="footer">
    <p>&copy; Blog 2019</p>
  </div>

  <script src="js/menu.js"></script>
</body>
</html>
