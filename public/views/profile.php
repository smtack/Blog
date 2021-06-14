<div class="submit">
  <?php if($profile_info['user_profile_picture']): ?>
    <img src="../uploads/profile-pictures/<?php echo $profile_info['user_profile_picture']; ?>" alt="<?php echo $profile_info['user_profile_picture']; ?>">
  <?php endif; ?>

  <h2><?php echo $profile_info['user_name']; ?>'s Profile</h2>
  <h4><a href="/profile/<?php echo $profile_info['user_username']; ?>"><?php echo $profile_info['user_name']; ?></a> @<?php echo $profile_info['user_username']; ?></h4>
  <p>Joined on <?php echo date('l j F Y', strtotime($profile_info['user_joined'])); ?></p>

  <p>
    <?php echo $profile_data['post_count'] . " "; echo($profile_data['post_count'] != 1) ? "Posts" : "Post"; ?>
    <?php echo $profile_data['followers'] . " "; echo($profile_data['followers'] != 1) ? "Followers" : "Follower"; ?>
    <?php echo "Following " . $profile_data['following']; ?>
  </p>

  <?php if($user->user_username !== $profile_info['user_username']): ?>
    <a class="follow" href="/<?php echo($profile_data['followed']) ? 'unfollow' : 'follow'; ?>/<?php echo $profile_info['user_id']; ?>"><?php echo($profile_data['followed']) ? "unfollow" : "follow"; ?></a>
  <?php endif; ?>
</div>
<div class="posts">
  <?php if(!$posts): ?>
    <h3>This user hasn't made a post yet.</h3>
  <?php else: ?>
    <?php foreach($posts as $post): ?>
      <div class="post">
        <a href="/post/<?php echo $post['post_slug']; ?>"><h3><?php echo $post['post_title']; ?></h3></a>
        <span>
          By <?php echo $post['user_name']; ?> @<?php echo $post['user_username']; ?>
          on <?php echo date('l j F Y', strtotime($post['post_date'])); ?>
        </span>

        <?php if($post['post_image']): ?>
          <img src="../uploads/<?php echo $post['post_image']; ?>" alt="<?php echo $post['post_image']; ?>">
        <?php endif; ?>

        <p><?php echo substr($post['post_content'], 0, 150); ?></p>

        <?php if($user->user_id === $post['post_by']): ?>
          <a href="/edit-post/<?php echo $post['post_slug']; ?>">Edit</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>