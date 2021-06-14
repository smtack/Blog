<div class="submit">
  <h2>Search Posts</h2>

  <form action="/posts" method="POST">
    <input name="query" type="text">
    <input type="submit" value="Search">
  </form>
</div>
<div class="posts">
  <?php if(!$posts): ?>
    <h3>No Posts Found</h3>
  <?php else: ?>
    <?php foreach($posts as $post): ?>
      <div class="post">
        <a href="/post/<?php echo $post['post_slug']; ?>"><h3><?php echo $post['post_title']; ?></h3></a>
        <span>
          By <a href="/profile/<?php echo $post['user_username']; ?>"><?php echo $post['user_name']; ?></a> @<?php echo $post['user_username']; ?>
          on <?php echo date('l j F Y', strtotime($post['post_date'])); ?>
        </span>

        <?php if($post['post_image']): ?>
          <img src="../uploads/<?php echo $post['post_image']; ?>" alt="<?php echo $post['post_image']; ?>">
        <?php endif; ?>

        <p><?php echo substr($post['post_content'], 0, 150); ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>