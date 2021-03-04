<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <div class="content">
    <div class="post">
      <img src="<?php echo BASE_URL; ?>/uploads/<?php echo $post_data['image']; ?>" alt="<?php echo $post_data['image']; ?>">
      <h3><?php echo $post_data['title']; ?></h3>
      <p><?php echo $post_data['content']; ?></p>
      <span><?php echo $post_data['name']; ?></span>
      <span><?php echo $post_data['datetime']; ?></span>

      <?php if($_SESSION['username'] == $post_data['username']): ?>
        <p><a href="<?php echo BASE_URL; ?>/delete_post.php?id=<?php echo $post_data['id']; ?>">Delete</a></p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>