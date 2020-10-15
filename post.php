<?php
$id = isset($_GET['id']) ? $_GET['id'] : die("Missing ID");

include_once "php/Database.php";
include_once "php/Post.php";
include_once "php/User.php";
include_once "php/core.php";

$database = new Database();
$newDB = $database->DB();

$post = new Post($newDB);
$post->id = $id;

$post->readOne();
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="css/main.css" rel="stylesheet">

  <title><?php echo $post->title; ?> - Blog</title>
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
    <div class="post-content">
      <h2><?php echo $post->title; ?></h2>

      <p class="datetime"><?php echo $post->datetime; ?></p>
      <p class="name"><?php echo $post->name; ?>

      <p class="content"><?php echo $post->content; ?></p>
    </div>
  </div>

  <div class="footer">
    <p>&copy; Blog 2019</p>
  </div>

  <script src="js/menu.js"></script>
</body>
</html>
