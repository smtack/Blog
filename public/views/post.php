<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <div class="content">
    <div class="single-post">
      <h3><?php echo $post_data['title']; ?></h3>
      <h5><?php echo $post_data['name']; ?>&nbsp;<?php echo $post_data['datetime']; ?></h5>

      <?php if($post_data['image']): ?>
        <img src="<?php echo BASE_URL; ?>/uploads/<?php echo $post_data['image']; ?>" alt="<?php echo $post_data['image']; ?>">
      <?php endif; ?>

      <p><?php echo $post_data['content']; ?></p>
      
      <?php if($_SESSION['username'] == $post_data['username']): ?>
        <span>
          <a href="<?php echo BASE_URL; ?>/update_post?id=<?php echo $post_data['id']; ?>">Update</a>
          <a href="<?php echo BASE_URL; ?>/delete_post?id=<?php echo $post_data['id']; ?>">Delete</a>
        </span>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>