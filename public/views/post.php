<div class="single-post">
  <h1><?php echo $post['post_title']; ?></h1>
  <span>
    By <a href="/profile/<?php echo $post['user_username']; ?>"><?php echo $post['user_name']; ?></a> @<?php echo $post['user_username']; ?>
    on <?php echo date('l j F Y', strtotime($post['post_date'])); ?>
  </span>

  <?php if($post['post_image']): ?>
    <img src="../uploads/<?php echo $post['post_image']; ?>" alt="<?php echo $post['post_image']; ?>">
  <?php endif; ?>

  <p><?php echo $post['post_content']; ?></p>

  <div class="comments">
    <h2>Comments</h2>

    <form action="/new-comment/<?php echo $post['post_id']; ?>" method="POST">
      <textarea name="comment" placeholder="Comment"></textarea>
      <input type="submit" value="Comment">
    </form>

    <?php foreach($comments as $comment): ?>
      <div class="comment">
        <p><?php echo $comment['comment_text']; ?></p>
        <span>By <?php echo $comment['user_name']; ?> on <?php echo date('l j F Y', strtotime($comment['comment_date'])); ?></span>
      </div>
    <?php endforeach; ?>
  </div>
</div>