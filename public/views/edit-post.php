<div class="create">
  <h2>Edit Post - <?php echo $postData['post_title']; ?></h2>

  <form enctype="multipart/form-data" action="/update-post/<?php echo $postData['post_slug']; ?>" method="POST">
    <input type="title" name="title" value="<?php echo $postData['post_title']; ?>">
    <input type="file" name="image">
    <textarea name="content"><?php echo $postData['post_content']; ?></textarea>
    <input type="submit" value="Edit Post">
  </form>

  <h2>Delete Post</h2>

  <form action="/delete-post/<?php echo $postData['post_slug']; ?>" method="POST">
    <input type="submit" value="Delete Post">
  </form>
</div>