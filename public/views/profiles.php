<div class="submit">
  <h2>Search for Profiles</h2>

  <form action="/profiles" method="POST">
    <input name="query" type="text">
    <input type="submit" value="Search">
  </form>
</div>
<div class="posts">
  <h2>Public profiles</h2>

  <?php if(!$profiles): ?>
    <h3>No Users Found</h3>
  <?php else: ?>
    <?php foreach($profiles as $user): ?>
      <div class="post">
        <span><a href="/profile/<?php echo $user['user_username']; ?>"><?php echo $user['user_name']; ?></a> @<?php echo $user['user_username']; ?></span>
        <span><?php echo $user['followers']; echo($user['followers'] != 1) ? " followers " : " follower "; ?></span>
        <a href="<?php echo($user['followed']) ? 'unfollow' : 'follow'; ?>/<?php echo $user['user_id']; ?>"><?php echo($user['followed']) ? "unfollow" : "follow"; ?></a>
        <p>Last Post: <?php echo $user['post_title']; ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>