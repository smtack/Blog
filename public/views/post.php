<?php require_once 'includes/header.php'; ?>

<?php require_once 'includes/navbar.php'; ?>

<div class="content">
  <div class="single-post">
    <h3><?php echo $post_data['post_title']; ?></h3>
    <h5>By <a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $post_data['user_id']; ?>"><?php echo $post_data['user_name']; ?></a> on <?php echo date('l j F Y', strtotime($post_data['post_date'])); ?></h5>

    <?php if($post_data['post_image']): ?>
      <img src="<?php echo BASE_URL; ?>/uploads/<?php echo $post_data['post_image']; ?>" alt="<?php echo $post_data['post_image']; ?>">
    <?php endif; ?>

    <p><?php echo $post_data['post_content']; ?></p>
    
    <?php if($_SESSION['username'] == $post_data['user_username']): ?>
      <span>
        <a href="<?php echo BASE_URL; ?>/edit?id=<?php echo $post_data['post_id']; ?>">Edit</a>
      </span>
    <?php endif; ?>
  </div>
  <div class="comments">
    <h3>Comments</h3>

    <div class="form">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <textarea name="comment_text"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="post_comment" value="Comment">
        </div>
      </form>
    </div>
    <div class="comments-list">
      <?php if(!$comments): ?>
        <p>No Comments</p>
      <?php endif; ?>
      <?php foreach($comments as $comment): ?>
        <div class="comment">
          <p><?php echo $comment['comment_text']; ?></p>
          <span>
            <?php echo date('l j F Y', strtotime($comment['comment_date'])); ?> by
            <a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $comment['comment_by']; ?>"><?php echo $comment['user_name']; ?></a>
          </span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>