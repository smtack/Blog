<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <div class="content">
    <div class="submit">
      <div class="info">
        <span><?php echo $user_data['name']; ?>'s Profile</span>
      </div>
    </div>

    <div class="posts">
      <?php foreach($posts as $single_post): ?>
        <div class="post">
          <img src="<?php echo BASE_URL; ?>/uploads/<?php echo $single_post['image']; ?>" alt="<?php echo $single_post['image']; ?>">
          <h3><a href="<?php echo BASE_URL; ?>/post.php?id=<?php echo $single_post['id']; ?>"><?php echo $single_post['title']; ?></a></h3>
          <p><?php echo substr($single_post['content'], 0, 150); ?><a href="<?php echo BASE_URL; ?>/post.php?id=<?php echo $single_post['id']; ?>">&nbsp;Read more</a></p></p>
          <span><?php echo $single_post['name']; ?></span>
          <span><?php echo $single_post['datetime']; ?></span>

          <?php if($_SESSION['username'] == $single_post['username']): ?>
            <p><a href="<?php echo BASE_URL; ?>/delete_post.php?id=<?php echo $single_post['id']; ?>">Delete</a></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>