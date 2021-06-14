<div class="index-forms">
  <h2>Welcome to Blog. Log in or make an account.</h2>

  <div class="buttons">
    <button class="signup-button">Sign Up</button>
    <button class="login-button">Log In</button>
  </div>
  <div class="signup-form">
    <form action="/signup" method="POST">
      <input name="name" type="text" placeholder="Name">
      <input name="username" type="text" placeholder="Username">
      <input name="email" type="text" placeholder="Email">
      <input name="password" type="password" placeholder="Password">
      <input name="confirm_password" type="password" placeholder="Confirm Password">
      <input type="submit" value="Sign Up">
    </form>
  </div>
  <div class="login-form">
    <form action="/login" method="POST">
      <input name="username" type="text" placeholder="Username">
      <input name="password" type="password" placeholder="Password">
      <input type="submit" value="Log In">
    </form>
  </div>
</div>