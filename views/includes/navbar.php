<div class="header">
  <h1><a href="home">Blog</a></h1>

  <span id="menu-button"><img src="img/menu.png"></span>

  <div id="menu">
    <ul>
      <li>
        <div class="search">
          <form action="search" method="get">
            <input type="text" name="s" placeholder="Search"></input>
          </form>
        </div>
      </li>
      <li><a href="profile?username=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a></li>
      <li><a href="create">Create</a></li>
      <li><a href="users">Users</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</div>