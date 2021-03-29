<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <div class="content">
    <div class="info">
      <h3>Welcome <a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $user_data['id']; ?>"><?php echo $user_data['name']; ?></a></h3>
    </div>

    <div class="posts">
      <?php if(!$posts): ?>
        <p>You haven't made a post yet. <a href="<?php echo BASE_URL; ?>/create">Create one</a></p>
      <?php endif; ?>

      <?php foreach($posts as $single_post): ?>
        <div class="post">
          <h3><a href="<?php echo BASE_URL; ?>/post?id=<?php echo $single_post['id']; ?>"><?php echo $single_post['title']; ?></a></h3>
          <span><?php echo $single_post['name']; ?></span>
          <span><?php echo $single_post['datetime']; ?></span>

          <?php if($single_post['image']): ?>
            <img src="<?php echo BASE_URL; ?>/uploads/<?php echo $single_post['image']; ?>" alt="<?php echo $single_post['image']; ?>">
          <?php endif; ?>
          
          <p><?php echo substr($single_post['content'], 0, 150); ?><a href="<?php echo BASE_URL; ?>/post?id=<?php echo $single_post['id']; ?>">&nbsp;Read more</a></p>
          
          <span>
            <a href="<?php echo BASE_URL; ?>/update_post?id=<?php echo $single_post['id']; ?>">Update</a>
            <a href="<?php echo BASE_URL; ?>/delete_post?id=<?php echo $single_post['id']; ?>">Delete</a>
          </span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>