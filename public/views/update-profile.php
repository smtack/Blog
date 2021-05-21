<?php require_once 'includes/header.php'; ?>

<?php require_once 'includes/navbar.php'; ?>

<div class="content">
  <h2>Update Profile</h2>

  <div class="form">
    <form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <h3>Profile Picture</h3>
      </div>
      <div class="form-group">
        <?php if(isset($error)): ?>
          <p><?php echo $error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="file" name="profile-picture">
      </div>
      <div class="form-group">
        <input type="submit" name="submit-profile-picture">
      </div>
    </form>
  </div>
  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <h3>User Info</h3>
      </div>
      <div class="form-group">
        <?php if(isset($info_error)): ?>
          <p><?php echo $info_error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="text" name="name" value="<?php echo $user_data['user_name']; ?>" placeholder="Name">
      </div>
      <div class="form-group">
        <input type="text" name="username" value="<?php echo $user_data['user_username']; ?>" disabled>
      </div>
      <div class="form-group">
        <input type="text" name="email" value="<?php echo $user_data['user_email']; ?>" placeholder="Email">
      </div>
      <div class="form-group">
        <input type="submit" name="update" value="Update">
      </div>
    </form>
  </div>
  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <h3>Change Password</h3>
      </div>
      <div class="form-group">
        <?php if(isset($password_error)): ?>
          <p><?php echo $password_error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
      </div>
      <div class="form-group">
        <input type="password" name="new_password" placeholder="New Password">
      </div>
      <div class="form-group">
        <input type="password" name="confirm_new_password" placeholder="Confirm New Password">
      </div>
      <div class="form-group">
        <input type="submit" name="change_password" value="Change Password">
      </div>
    </form>
  </div>
  <div class="form">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <h3>Delete Profile</h3>
      </div>
      <div class="form-group">
        <?php if(isset($delete_error)): ?>
          <p><?php echo $delete_error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="submit" name="delete-profile" value="Delete Profile">
      </div>
    </form>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>