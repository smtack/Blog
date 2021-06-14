<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/Resource/public/css/style.css" rel="stylesheet">
  <script src="/Resource/public/js/main.js" defer></script>
  <title><?php echo $page_title; ?></title>
</head>
<body>
  <header>
    <?php if($user !== false): ?>
      <h1 id="logo"><a href="/home">Blog</a></h1>
    <?php else: ?>
      <h1 id="logo"><a href="/index">Blog</a></h1>
    <?php endif; ?>

    <?php if($user !== false): ?>
      <img class="menu-button" src="/Resource/public/img/menu.png" alt="Menu">

      <div class="nav">
        <ul>
          <a href="/profile/<?php echo $user->user_username; ?>"><li>Your Profile</li></a>
          <a href="/update-profile"><li>Update Profile</li></a>
          <a href="/logout"><li>Log Out</li></a>
        </ul>
      </div>
    <?php endif; ?>
  </header>

  <div class="content">