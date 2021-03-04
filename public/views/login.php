<?php require_once 'includes/header.php'; ?>

<div class="container">
  <h1>Blog</h1>

  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-group">
      <input type="text" name="username" placeholder="Username">
    </div>
    <div class="form-group">
      <input type="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
      <input type="submit" name="login" value="Log In">
    </div>
    <div class="form-group">
      <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/index.php">Sign Up</a></p>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>