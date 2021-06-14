<div class="submit">
  <?php if($user->user_profile_picture): ?>
    <img src="../uploads/profile-pictures/<?php echo $user->user_profile_picture; ?>" alt="<?php echo $user->user_profile_picture; ?>">
  <?php endif; ?>
  
  <h2>Welcome <?php echo $user->user_name; ?></h2>
  <h4><a href="/profile/<?php echo $user->user_username; ?>">@<?php echo $user->user_username; ?></a></h4>

  <p>
    <?php echo $userData['post_count'] . " "; echo($userData['post_count'] != 1) ? "Posts" : "Post"; ?>
    <span><?php echo $userData['followers'] . " "; echo($userData['followers'] != 1) ? "Followers" : "Follower"; ?></span>
    <span><?php echo "Following " . $userData['following']; ?></span><br>
  </p>

  <h2>Create a Post</h2>

  <form action="/create" method="POST">
    <input type="submit" value="Create a Post">
  </form>

  <h2>Search Posts</h2>

  <form action="/posts" method="POST">
    <input name="query" type="text">
    <input type="submit" value="Search">
  </form>

  <h2>Search for Profiles</h2>

  <form action="/profiles" method="POST">
    <input name="query" type="text">
    <input type="submit" value="Search">
  </form>
</div>
<div class="posts">
  <?php if(!$followers_posts): ?>
    <h3>You aren't following anyone yet. <a href="/profiles">Take a look at the public profiles</a></h3>
  <?php endif; ?>
  
  <?php foreach($followers_posts as $post): ?>
    <div class="post">
      <h3><a href="/post/<?php echo($post['post_slug']); ?>"><?php echo $post['post_title']; ?></a></h3>
      <span>
        By <a href="/profile/<?php echo $post['user_username']; ?>"><?php echo $post['user_name']; ?></a> @<?php echo $post['user_username']; ?>
        on <?php echo date('l j F Y', strtotime($post['post_date'])); ?>
      </span>

      <?php if($post['post_image']): ?>
        <img src="../uploads/<?php echo $post['post_image']; ?>" alt="<?php echo $post['post_image']; ?>">
      <?php endif; ?>

      <p><?php echo substr($post['post_content'], 0, 150); ?></p>

      <?php if($user->user_id === $post['post_by']): ?>
        <p><a href="/edit-post/<?php echo $post['post_slug']; ?>">Edit</a></p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>