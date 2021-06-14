<div class="create">
  <h2>Update Profile</h2>

  <div class="form">
    <form action="/update-info" method="POST">
      <input name="name" type="text" value="<?php echo $user->user_name; ?>">
      <input name="username" type="text" value="<?php echo $user->user_username; ?>">
      <input name="email" type="text" value="<?php echo $user->user_email; ?>">
      <input type="submit" value="Update Info">
    </form>
  </div>

  <h2>Edit Profile Picture</h2>

  <div class="form">
    <form enctype="multipart/form-data" action="edit-profile-picture" method="POST">
      <input type="file" name="profile-picture">
      <input type="submit" value="Edit Profile Picture">
    </form>
  </div>

  <h2>Change Password</h2>

  <div class="form">
    <form action="/change-password" method="POST">
      <input name="current_password" type="password" placeholder="Current Password">
      <input name="new_password" type="password" placeholder="New Password">
      <input name="confirm_password" type="password" placeholder="Confirm New Password">
      <input type="submit" value="Change Password">
    </form>
  </div>

  <h2>Delete Profile</h2>

  <div class="form">
    <form action="/delete-profile" method="POST">
      <input type="submit" value="Delete Profile">
    </form>
  </div>
</div>