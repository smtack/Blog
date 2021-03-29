<?php require_once 'includes/header.php'; ?>

<div class="container">
  <?php require_once 'includes/navbar.php'; ?>

  <div class="content">
    <div class="search-results">
      <?php if(!$results): ?>
        <h3 class="no-results">No results</h3>
      <?php endif; ?>
      
      <?php foreach($results as $single_user): ?>
        <div class="post">
          <p><a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $single_user['id']; ?>"><?php echo $single_user['name']; ?></a></p>
          <span><?php echo $single_user['username']; ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>