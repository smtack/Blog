<?php require_once 'includes/header.php'; ?>

<div class="content">
  <h1>Blog</h1>

  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <?php if(isset($error)): ?>
          <p><?php echo $error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="text" name="name" placeholder="Name">
      </div>
      <div class="form-group">
        <input type="text" name="username" placeholder="Username">
      </div>
      <div class="form-group">
        <input type="text" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <input type="password" name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
      </div>
      <div class="form-group">
        <input type="submit" name="signup" value="Sign Up">
      </div>
      <div class="form-group">
        <p>Already have an account? <a href="<?php echo BASE_URL; ?>/login">Log In</a></p>
      </div>
    </form>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>