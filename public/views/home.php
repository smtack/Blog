<?php require_once 'includes/header.php'; ?>

<?php require_once 'includes/navbar.php'; ?>

<div class="content">
  <div class="info">
    <?php if($user_data['user_profile_picture']): ?>
      <img class="profile-picture" src="<?php echo BASE_URL; ?>/uploads/profile-pictures/<?php echo $user_data['user_profile_picture']; ?>" alt="<?php echo $user_data['user_profile_picture']; ?>">
    <?php endif; ?>

    <h3>Welcome <a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $user_data['user_id']; ?>"><?php echo $user_data['user_name']; ?></a></h3>
  </div>

  <div class="posts">
    <?php if(!$posts): ?>
      <p>You haven't made a post yet. <a href="<?php echo BASE_URL; ?>/create">Create one</a></p>
    <?php endif; ?>

    <?php foreach($posts as $single_post): ?>
      <div class="post">
        <?php if($single_post['post_image']): ?>
          <img class="post-image" src="<?php echo BASE_URL; ?>/uploads/<?php echo $single_post['post_image']; ?>" alt="<?php echo $single_post['post_image']; ?>">
        <?php endif; ?>

        <h3><a href="<?php echo BASE_URL; ?>/post?id=<?php echo $single_post['post_id']; ?>"><?php echo $single_post['post_title']; ?></a></h3>

        <span>
          By <?php echo $single_post['user_name']; ?> on
          <?php echo date('l j F Y', strtotime($single_post['post_date'])); ?>
        </span>

        <p><?php echo substr($single_post['post_content'], 0, 150); ?>... <a href="<?php echo BASE_URL; ?>/post?id=<?php echo $single_post['post_id']; ?>">Read more</a></p>
      
        <span>
          <a href="<?php echo BASE_URL; ?>/edit?id=<?php echo $single_post['post_id']; ?>">Edit</a>
        </span>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>