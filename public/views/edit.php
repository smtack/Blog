<?php require_once "includes/header.php"; ?>

<?php require_once "includes/navbar.php"; ?>

<div class="content">
  <div class="form">
    <h2>Edit Post</h2>

    <form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <?php if(isset($error)): ?>
          <p><?php echo $error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="text" name="title" value="<?php echo $post_data['post_title']; ?>">
      </div>
      <div class="form-group">
        <input type="file" name="image">
      </div>
      <div class="form-group">
        <textarea name="content"><?php echo $post_data['post_content']; ?></textarea>
      </div>
      <div class="form-group">
        <input type="submit" name="update_post" value="Update">
      </div>
    </form>
  </div>
  <div class="form">
    <h3>Delete Post</h3>
    
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <?php if(isset($error)): ?>
          <p><?php echo $error; ?></p>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <input type="submit" name="delete" value="Delete Post">
      </div>
    </form>
  </div>
</div>

<?php require_once "includes/footer.php"; ?>