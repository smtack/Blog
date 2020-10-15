<?php
if (isset($_POST['signup'])) {
  include_once "php/Database.php";
  include_once "php/User.php";
  include_once "php/core.php";

  $database = new Database();
  $newDB = $database->DB();

  $user = new User($newDB);

  $user->name = $_POST['name'];
  $user->username = $_POST['username'];
  $user->email = $_POST['email'];
  $user->password = $_POST['password'];

  if ($user->signup()) {
    $_SESSION['name'] = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8');
    $_SESSION['username'] = htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8');
    $_SESSION['email'] = htmlspecialchars($user->email);
    $_SESSION['loggedIn'] = 1;

    header("Location: home.php");
  } else {
    echo "Unable to sign up.";
  }
}

if (isset($_POST['login'])) {
  include_once "php/Database.php";
  include_once "php/User.php";
  include_once "php/core.php";

  $database = new Database();
  $newDB = $database->DB();

  $user = new User($newDB);

  $user->email = $_POST['email'];

  $checkUser = $user->checkUser();

  if ($checkUser && password_verify($_POST['password'], $user->password)) {
    $_SESSION['name'] = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8');
    $_SESSION['username'] = htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8');
    $_SESSION['email'] = htmlspecialchars($user->email);
    $_SESSION['loggedIn'] = 1;

    header("Location: home.php");
  } else {
    echo "Failed to log in";
  }
}
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
  <div class="section-left">
    <h1 id="logo">Blog</h1>
  </div>

  <div class="section-right">
    <div class="toggle-form">
      <ul>
        <li><button id="signupButton">Sign Up</button></li>
        <li><button id="loginButton">Log In</button></li>
      </ul>
    </div>

    <div class="signup-login">
      <div id="signup">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <ul>
            <li>
              <label for="name">Name</label>
              <input type="text" name="name">
            </li>
            <li>
              <label for="username">Username</label>
              <input type="text" name="username">
            </li>
            <li>
              <label for="email">Email</label>
              <input type="email" name="email">
            </li>
            <li>
              <label for="password">Password</label>
              <input type="password" name="password">
            </li>
            <li>
              <input type="submit" name="signup" value="Sign Up">
            </li>
          </ul>
        </form>
      </div>
      <div id="login">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <ul>
            <li>
              <label for="email">Email</label>
              <input type="email" name="email">
            </li>
            <li>
              <label for="password">Password</label>
              <input type="password" name="password">
            </li>
            <li>
              <input type="submit" name="login" value="Log In">
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>

  <div class="footer">
    <p>&copy; Blog 2019</p>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
