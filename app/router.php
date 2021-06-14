<?php
class Router {
  private $routes;

  function __construct() {
    $this->routes = array(
      "index" => "index",
      "signup" => "signUp",
      "login" => "logIn",
      "logout" => "logOut",
      "home" => "home",
      "create" => "create",
      "new-post" => "newPost",
      "posts" => "posts",
      "post" => "post",
      "edit-post" => "editPost",
      "update-post" => "updatePost",
      "delete-post" =>"deletePost",
      "new-comment" => "newComment",
      "profiles" => "profiles",
      "profile" => "profile",
      "follow" => "follow",
      "unfollow" => "unfollow",
      "update-profile" => "updateProfile",
      "update-info" => "updateInfo",
      "edit-profile-picture" => "editProfilePicture",
      "change-password" => "changePassword",
      "delete-profile" => "deleteProfile"
    );
  }

  public function lookup($query) {
    if(array_key_exists($query, $this->routes)) {
      return $this->routes[$query];
    } else {
      return false;
    }
  }
}