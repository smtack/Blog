<?php
require("model.php");
require("router.php");
require("flash.php");

class Controller {
  private $model;
  private $router;

  function __construct() {
    $this->model = new Model();
    $this->router = new Router();

    $queryParams = false;

    if(strlen($_GET['query']) > 0) {
      $queryParams = explode("/", $_GET['query']);
    }

    $page = $_GET['page'];

    $endpoint = $this->router->lookup($page);

    if($endpoint === false) {
      header("HTTP/1.0 404 Not Found");
      include("public/views/errors/404.php");
    } else {
      $this->$endpoint($queryParams);
    }
  }

  private function redirect($url) {
    header("Location: /" . $url);
  }

  private function loadView($view, $data = null, $page_title = null) {
    if(is_array($data)) {
      extract($data);
    }
    
    require("public/views/" . $view . ".php");
  }

  private function loadPage($user, $view, $data = null, $page_title = null, $flash = false) {
    $this->loadView("/includes/header", array('user' => $user), $page_title);

    if($flash !== false) {
      $flash->display();
    }

    $this->loadView($view, $data, $page_title);
    $this->loadView("includes/footer");
  }

  private function checkAuth() {
    if(isset($_COOKIE['Auth'])) {
      return $this->model->userForAuth($_COOKIE['Auth']);
    } else {
      return false;
    }
  }

  private function index($params) {
    $user = $this->checkAuth();
    $page_title = "Blog - Sign Up or Log In";

    if($user !== false) {
      $this->redirect("home");
    } else {
      $flash = false;

      if($params !== false) {
        $flashArr = array(
          "0" => new Flash("Your Username and/or Password was incorrect.", "error"),
          "1" => new Flash("Theres already a user with that email address.", "error"),
          "2" => new Flash("That username has already been taken.", "error"),
          "3" => new Flash("Passwords don't match.", "error"),
          "4" => new Flash("Your Password must be at least 6 characters long.", "error"),
          "5" => new Flash("You must enter a valid Email address.", "error"),
          "6" => new Flash("Fill in all fields", "error"),
          "7" => new Flash("You have to be signed in to access that page.", "warning"),
          "8" => new Flash("Wrong Password.", "error"),
          "9" => new Flash("Profile successfully deleted.", "notice")
        );

        $flash = $flashArr[$params[0]];
      }

      $this->loadPage($user, "index", array(), $page_title, $flash);
    }
  }

  private function signUp() {
    if(empty($_POST['email']) || strpos($_POST['email'], "@") === false) {
      $this->redirect("index/5");
    } else if(empty($_POST['name']) || empty($_POST['username'])) {
      $this->redirect("index/6");
    } else if(strlen($_POST['password']) < 6) {
      $this->redirect("index/4");
    } else if($_POST['password'] != $_POST['confirm_password']) {
      $this->redirect("index/3");
    } else {
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

      $signupInfo = array(
        'user_name' => htmlentities($_POST['name']),
        'user_username' => htmlentities($_POST['username']),
        'user_email' => htmlentities($_POST['email']),
        'user_password' => $password,
        'user_joined' => date('Y-m-d H:i:s')
      );

      $resp = $this->model->signupUser($signupInfo);

      if($resp === true) {
        $this->redirect("home/1");
      } else {
        $this->redirect("index/" . $resp);
      }
    }
  }

  private function logIn() {
    $loginInfo = array(
      'user_username' => $_POST['username'],
      'user_password' => $_POST['password']
    );

    if($this->model->attemptLogin($loginInfo)) {
      $this->redirect("home/0");
    } else {
      $this->redirect("index/0");
    }
  }

  private function logOut() {
    $this->model->logoutUser($_COOKIE['Auth']);
    $this->redirect("index");
  }

  private function home($params) {
    $user = $this->checkAuth();
    $page_title = "Blog - Home";

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $userData = $this->model->getUserInfo($user);
      $followers_posts = $this->model->getFollowersPosts($user);
      $flash = false;

      if(isset($params[0])) {
        $flashArr = array(
          "0" => new Flash("Welcome Back, " . $user->user_name, "notice"),
          "1" => new Flash("Welcome to Blog, " . $user->user_name . ". Thanks for signing up.", "notice"),
          "2" => new Flash("Profile successfully updated", "notice"),
          "3" => new Flash("Password successfully updated", "notice"),
          "4" => new Flash("Fill in both fields", "error"),
          "5" => new Flash("The Title cannot be longer than 150 characters", "error"),
          "6" => new Flash("You have exceeded the 5000 character limit for Posts", "error"),
          "7" => new Flash("Post updated successfully", "notice"),
          "8" => new Flash("Unable to update post", "error"),
          "9" => new Flash("Post successfully deleted", "notice"),
          "10" => new Flash("Unable to delete post", "error"),
          "11" => new Flash("Fill in the text field", "error"),
          "12" => new Flash("This file type is not supported", "error"),
          "13" => new Flash("Profile picture updated", "notice")
        );
        
        $flash = $flashArr[$params[0]];
      }

      $this->loadPage($user, "home", array('user' => $user, "userData" => $userData, "followers_posts" => $followers_posts), $page_title, $flash);
    }
  }

  private function create($params) {
    $user = $this->checkAuth();
    $page_title = "Blog - Create new post";

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $userData = $this->model->getUserInfo($user);
      $flash = false;

      if(isset($params[0])) {
        $flashArr = array(
          "0" => new Flash("Fill in both fields", "error"),
          "1" => new Flash("The Title cannot be longer than 150 characters", "error"),
          "2" => new Flash("You have exceeded the 5000 character limit for Posts", "error"),
          "3" => new Flash("This file type is not supported", "error")
        );

        $flash = $flashArr[$params[0]];
      }

      $this->loadPage($user, "create", array('user' => $user, "userData" => $userData), $page_title, $flash);
    }
  }

  private function newPost($params) {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      if(empty($_POST['title']) || empty($_POST['content'])) {
        $this->redirect("create/0");
      } else if(strlen($_POST['title']) > 150) {
        $this->redirect("create/1");
      } else if(strlen($_POST['content']) > 5000) {
        $this->redirect("create/2");
      } else if(!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES['image']['name']);
        $path = $target_dir . $file_name;
        $file_type = pathinfo($path, PATHINFO_EXTENSION);
        $allow_types = array('jpg', 'png', 'gif');

        if(in_array($file_type, $allow_types)) {
          if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            $post_image = $file_name;

            $this->model->newPost($user, $post_image);
            $this->redirect("home");
          }
        } else {
          $this->redirect("create/3");
        }
      } else {
        $this->model->newPost($user);
        $this->redirect("home");
      }
    }
  }

  private function posts($params) {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $q = false;

      if(isset($_POST['query'])) {
        $q = $_POST['query'];
      }

      $posts = $this->model->getPublicPosts($q);
      $page_title = "Blog - Public Posts: " . $q;

      $this->loadPage($user, "posts", array("posts" => $posts), $page_title);
    }
  }

  private function post() {
    $user = $this->checkAuth();

    if(isset($_GET['query'])) {
      $postQuery = $_GET['query'];

      if($post = $this->model->getPost($postQuery)) {
        $comments = $this->model->getComments($post['post_id']);
        $page_title = "Blog - " . $post['post_title'];

        $this->loadPage($user, "post", array("post" => $post, "comments" => $comments), $page_title);
      } else {
        $this->redirect("home");
      }
    }
  }

  private function editPost() {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      if(isset($_GET['query'])) {
        $postQuery = $_GET['query'];

        if($postData = $this->model->getPost($postQuery)) {
          if($postData['post_by'] !== $user->user_id) {
            $this->redirect("home");
          } else {
            $page_title = "Blog - Edit Post: " . $postData['post_title'];

            $this->loadPage($user, "edit-post", array("postData" => $postData), $page_title);
          }
        } else {
          $this->redirect("home");
        }
      }
    }
  }

  private function updatePost() {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      if(empty($_POST['title']) || empty($_POST['content'])) {
        $this->redirect("home/4");
      } else if(strlen($_POST['title']) > 150) {
        $this->redirect("home/5");
      } else if(strlen($_POST['content']) > 5000) {
        $this->redirect("home/6");
      } else if(!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES['image']['name']);
        $path = $target_dir . $file_name;
        $file_type = pathinfo($path, PATHINFO_EXTENSION);
        $allow_types = array('jpg', 'png', 'gif');

        if(in_array($file_type, $allow_types)) {
          if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            $post_image = $file_name;

            $updateInfo = array(
              "current_slug" => $_GET['query'],
              "post_title" => htmlentities($_POST['title']),
              "post_image" => $post_image,
              "post_slug" => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', htmlentities($_POST['title'])))) . "-" . rand(0, 100),
              "post_content" => htmlentities($_POST['content'])
            );

            if($this->model->updatePost($updateInfo)) {
              $this->redirect("home/7");
            } else {
              $this->redirect("home/8");
            }
          }
        } else {
          $this->redirect("home/12");
        }
      } else {
        $updateInfo = array(
          "current_slug" => $_GET['query'],
          "post_title" => htmlentities($_POST['title']),
          "post_slug" => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', htmlentities($_POST['title'])))) . "-" . rand(0, 100),
          "post_content" => htmlentities($_POST['content'])
        );

        if($this->model->updatePost($updateInfo)) {
          $this->redirect("home/7");
        } else {
          $this->redirect("home/8");
        }
      }
    }
  }

  private function deletePost() {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $post = htmlentities($_GET['query']);

      if($this->model->deletePost($post)) {
        $this->redirect("home/9");
      } else {
        $this->redirect("home/10");
      }
    }
  }

  private function newComment() {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      if(empty($_POST['comment'])) {
        $this->redirect("home/11");
      } else {
        $commentInfo = array(
          'comment_text' => htmlentities($_POST['comment']),
          'comment_date' => date('Y-m-d H:i:s'),
          'comment_post' => htmlentities($_GET['query']),
          'comment_by' => $user->user_id
        );
  
        $this->model->newComment($commentInfo);
        $this->redirect("post/" . $commentInfo['comment_post']);
      }
    }
  }

  private function profiles($params) {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $q = false;

      if(isset($_POST['query'])) {
        $q = $_POST['query'];
      }

      $profiles = $this->model->getPublicProfiles($user, $q);
      $page_title = "Blog - Public Profiles: " . $q;

      $this->loadPage($user, "profiles", array("profiles" => $profiles), $page_title);
    }
  }

  private function profile($params) {
    $user = $this->checkAuth();

    if(isset($_GET['query'])) {
      $profile = $_GET['query'];

      if($profile_info = $this->model->getProfile($user, $profile)) {
        $profile_data = $this->model->getProfileInfo($user, $profile_info['user_id']);
        $posts = $this->model->getUsersPosts($profile_info['user_id']);
        $page_title = "Blog - " . $profile_info['user_name'] . "'s Profile";

        $this->loadPage($user, "profile", array("user" => $user, "profile" => $profile, "profile_info" => $profile_info, "profile_data" => $profile_data, "posts" => $posts), $page_title);
      } else {
        $this->redirect("profiles");
      }
    }
  }

  private function follow($params) {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $this->model->follow($user, $params[0]);
      $this->redirect("home");
    }
  }

  private function unfollow($params) {
    $user = $this->checkAuth();

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $this->model->unfollow($user, $params[0]);
      $this->redirect("home");
    }
  }

  private function updateProfile($params) {
    $user = $this->checkAuth();
    $page_title = "Blog - Update Profile";

    if($user === false) {
      $this->redirect("index/7");
    } else {
      $flash = false;

      if(isset($params[0])) {
        $flashArr = array(
          "0" => new Flash("Fill in all fields", "error"),
          "1" => new Flash("Enter a valid email address", "error"),
          "2" => new Flash("Enter your current password correctly", "error"),
          "3" => new Flash("Passwords do not match", "error"),
          "4" => new Flash("This username is taken", "error"),
          "5" => new Flash("This email is taken", "error"),
          "6" => new Flash("Unable to update profile", "error"),
          "7" => new Flash("Unable to change password", "error"),
          "8" => new Flash("Unable to delete profile", "error"),
          "9" => new Flash("File type is not supported", "error"),
          "10" => new Flash("Choose an image to upload", "warning")
        );

        $flash = $flashArr[$params[0]];

        if(!$flash) {
          $this->redirect("home");
        }
      }

      $this->loadPage($user, "update-profile", array("user" => $user), $page_title, $flash);
    }
  }

  private function updateInfo() {
    $user = $this->checkAuth();

    $userInfo = array(
      'user_username' => $user->user_username,
      'user_email' => $user->user_email
    );

    if(empty($_POST['name']) || empty($_POST['username']) || empty($_POST['email'])) {
      $this->redirect("update-profile/0");
    } else if(strpos($_POST['email'], "@") === false) {
      $this->redirect("update-profile/1");
    } else {
      $updateInfo = array(
        "user_id" => $user->user_id,
        "user_name" => htmlentities($_POST['name']),
        "user_username" => htmlentities($_POST['username']),
        "user_email" => htmlentities($_POST['email'])
      );

      $resp = $this->model->updateInfo($updateInfo, $userInfo);

      if($resp === true) {
        $this->redirect("home/2");
      } else {
        $this->redirect("update-profile/" . $resp);
      }
    }
  }

  private function editProfilePicture() {
    $user = $this->checkAuth();

    if(!empty($_FILES['profile-picture']['name'])) {
      $target_dir = "uploads/profile-pictures/";
      $file_name = basename($_FILES['profile-picture']['name']);
      $path = $target_dir . $file_name;
      $file_type = pathinfo($path, PATHINFO_EXTENSION);
      $allow_types = array('jpg', 'png', 'gif');

      if(in_array($file_type, $allow_types)) {
        if(move_uploaded_file($_FILES['profile-picture']['tmp_name'], $path)) {
          $user_profile_picture = $file_name;

          $profile_picture = array(
            'user_id' => $user->user_id,
            'user_profile_picture' => $user_profile_picture
          );

          if($this->model->editProfilePicture($profile_picture)) {
            $this->redirect("home/13");
          } else {
            $this->redirect("update-profile/6");
          }
        }
      } else {
        $this->redirect("update-profile/9");
      }
    } else {
      $this->redirect("update-profile/10");
    }
  }

  private function changePassword() {
    $user = $this->checkAuth();

    if(empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
      $this->redirect("update-profile/0");
    } else if(!password_verify($_POST['current_password'], $user->user_password)) {
      $this->redirect("update-profile/2");
    } else if($_POST['new_password'] !== $_POST['confirm_password']) {
      $this->redirect("update-profile/3");
    } else {
      $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

      $passwordInfo = array(
        "user_id" => $user->user_id,
        "password" => $password
      );

      if($this->model->changePassword($passwordInfo)) {
        $this->redirect("home/3");
      } else {
        $this->redirect("update-profile/7");
      }
    }
  }

  private function deleteProfile() {
    $user = $this->checkAuth();

    if($this->model->deleteProfile($user)) {
      $this->redirect("index/9");
    } else {
      $this->redirect("update-profile/8");
    }
  }
}