<?php require_once 'includes/header.php'; ?>

<?php require_once 'includes/navbar.php'; ?>

<div class="content">
  <div class="info">
    <?php if($user_data['user_profile_picture']): ?>
      <img class="profile-picture" src="<?php echo BASE_URL; ?>/uploads/profile-pictures/<?php echo $user_data['user_profile_picture']; ?>" alt="<?php echo $user_data['user_profile_picture']; ?>">
    <?php endif; ?>

    <h3><?php echo $user_data['user_name']; ?>'s Profile</h3>
    <p>Joined on <?php echo date('l j F Y', strtotime($user_data['user_joined'])); ?></p>
  </div>

  <div class="posts">
    <?php if(!$posts): ?>
      <?php if($_SESSION['username'] == $user_data['user_username']): ?>
        <p>You haven't made a post yet. <a href="<?php echo BASE_URL; ?>/create">Create one</a></p>
      <?php else: ?>
        <p><?php echo $user_data['user_name']; ?>&nbsp;hasn't made a post yet.</p>
      <?php endif; ?>
    <?php endif; ?>

    <?php foreach($posts as $single_post): ?>
      <div class="post">
        <?php if($single_post['post_image']): ?>
            <img class="post-image" src="<?php echo BASE_URL; ?>/uploads/<?php echo $single_post['post_image']; ?>" alt="<?php echo $single_post['post_image']; ?>">
        <?php endif; ?>

        <div class="post-content">
          <h3><a href="<?php echo BASE_URL; ?>/post?id=<?php echo $single_post['post_id']; ?>"><?php echo $single_post['post_title']; ?></a></h3>
        
          <span>
            By <?php echo $single_post['user_name']; ?> on
            <?php echo date('l j F Y', strtotime($single_post['post_date'])); ?>
          </span>

          <p><?php echo substr($single_post['post_content'], 0, 150); ?>... <a href="<?php echo BASE_URL; ?>/post.php?id=<?php echo $single_post['post_id']; ?>">Read more</a></p>
          
          <?php if($_SESSION['username'] == $single_post['user_username']): ?>
            <span>
              <a href="<?php echo BASE_URL; ?>/edit?id=<?php echo $single_post['post_id']; ?>">Edit</a>
            </span>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>