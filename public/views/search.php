<?php require_once 'includes/header.php'; ?>

<?php require_once 'includes/navbar.php'; ?>

<div class="content">
  <div class="search-results">
    <h2>Search Users</h2>

    <?php if(!$results): ?>
      <h3 class="no-results">No results</h3>
    <?php endif; ?>
    
    <?php foreach($results as $single_user): ?>
      <div class="result">
        <h3><a href="<?php echo BASE_URL; ?>/profile?id=<?php echo $single_user['user_id']; ?>"><?php echo $single_user['user_name']; ?></a></h3>
        <span><?php echo $single_user['user_username']; ?></span>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>