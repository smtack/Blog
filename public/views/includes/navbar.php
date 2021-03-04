<div class="navbar">
  <h1 id="logo"><a href="<?php echo BASE_URL; ?>/home.php">Blog</a></h1>

  <span class="search-button">Search</span>

  <div class="search">
    <form action="<?php echo BASE_URL; ?>/search.php" method="GET">
      <input type="text" name="search" placeholder="Search">
    </form>
  </div>

  <span class="menu-button">Options</span>

  <div class="menu">
    <ul>
      <li><a href="<?php echo BASE_URL; ?>/update.php?id=<?php echo $user_data['id']; ?>">Update profile</a></li>
      <li><a href="<?php echo BASE_URL; ?>/logout.php">Log out</a></li>
    </ul>
  </div>
</div>