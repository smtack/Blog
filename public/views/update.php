<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <h2>Update Profile</h2>

  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <input type="text" name="name" value="<?php echo $user_data['name']; ?>">
      </div>
      <div class="form-group">
        <input type="text" name="username" value="<?php echo $user_data['username']; ?>">
      </div>
      <div class="form-group">
        <input type="text" name="email" value="<?php echo $user_data['email']; ?>">
      </div>
      <div class="form-group">
        <input type="submit" name="update" value="Update">
      </div>
    </form>
  </div>
  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <p>Change Password</p>
      </div>
      <div class="form-group">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
      </div>
      <div class="form-group">
        <input type="password" name="new_password" placeholder="New Password">
      </div>
      <div class="form-group">
        <input type="submit" name="change_password" value="Change Password">
      </div>
    </form>
  </div>
  <div class="form">
    <div class="form-group">
      <p><a href="<?php echo BASE_URL; ?>/delete?id=<?php echo $user_data['id']; ?>">Delete account</a></p>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>