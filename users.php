<?php
include_once "php/Database.php";
include_once "php/Post.php";
include_once "php/User.php";
include_once "php/core.php";

$database = new Database();
$newDB = $database->DB();

$user = new User($newDB);

$stmt = $user->readUsers();
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="css/main.css" rel="stylesheet">

  <title>Blog</title>
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
    <div class="posts">
      <?php
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        echo("
          <div class='post'>
            <h3 class='title'><a href='profile.php?username={$username}'>{$name}</a></h3>
        ");

        echo ("</div>");
      }
      ?>
    </div>
  </div>

  <div class="footer">
    <p>&copy; Blog 2019</p>
  </div>

  <script src="js/menu.js"></script>
</body>
</html>
