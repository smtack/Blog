<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <div class="content">
    <div class="submit">
      <div class="info">
        <span>Welcome <a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $user_data['id']; ?>"><?php echo $user_data['name']; ?></a></span>
      </div>

      <form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
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

    <div class="posts">
      <?php if(!$posts): ?>
        <p>You haven't made a post yet</p>
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
          <p>
            <a href="<?php echo BASE_URL; ?>/update_post?id=<?php echo $single_post['id']; ?>">Update</a>
            <a href="<?php echo BASE_URL; ?>/delete_post?id=<?php echo $single_post['id']; ?>">Delete</a>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>