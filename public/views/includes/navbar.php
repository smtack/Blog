<div class="navbar">
  <h1 id="logo"><a href="<?php echo BASE_URL; ?>/home">Blog</a></h1>

  <img class="search-button" src="<?php echo BASE_URL; ?>/img/search.png" alt="Search">

  <div class="search">
    <form action="<?php echo BASE_URL; ?>/search" method="GET">
      <input type="text" name="search" placeholder="Search">
    </form>
  </div>

  <img class="menu-button" src="<?php echo BASE_URL; ?>/img/menu.png" alt="Search">

  <div class="menu">
    <ul>
      <li><a href="<?php echo BASE_URL; ?>/create">Create Post</a></li>
      <li><a href="<?php echo BASE_URL; ?>/update?id=<?php echo $user_data['id']; ?>">Update profile</a></li>
      <li><a href="<?php echo BASE_URL; ?>/logout">Log out</a></li>
    </ul>
  </div>
</div>