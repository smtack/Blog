<?php require_once "includes/header.php"; ?>

<div class="container">
  <?php require_once "includes/navbar.php"; ?>

  <div class="content">
    <div class="submit-post">
      <h2>Create Post</h2>

      <form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <?php if(isset($error)): ?>
            <p><?php echo $error; ?></p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <input type="text" name="title" placeholder="Title">
        </div>
        <div class="form-group">
          <input type="file" name="image">
        </div>
        <div class="form-group">
          <textarea name="content" placeholder="Text"></textarea>
        </div>
	      <div class="form-group">
	        <input type="submit" name="submit_post" value="Post">
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once "includes/footer.php"; ?>