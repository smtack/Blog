<?php
require('config.php');

class Model {
  private $dbhost = DB_HOST;
  private $dbname = DB_NAME;
  private $dbuser = DB_USER;
  private $dbpass = DB_PASS;
  private $dbchar = DB_CHAR;

  private $db;
  private $dsn;
  private $opt;

  function __construct() {
    $this->db = null;

    $this->dsn = 'mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname . ';charset=' . $this->dbchar;

    $this->opt =[
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
      $this->db = new PDO($this->dsn, $this->dbuser, $this->dbpass, $this->opt);
    } catch(PDOException $e) {
      die($e->getMessage());
    }

    return $this->db;
  }

  private function select($table, $arr) {
    $query = "SELECT * FROM " . $table;
    $pref = " WHERE ";

    foreach($arr as $key => $value) {
      $query .= $pref . $key . "='" . $value . "'";
      $pref = " AND ";
    }

    $query .= ";";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  private function insert($table, $arr) {
    $query = "INSERT INTO " . $table . " (";
    $pref = "";

    foreach($arr as $key => $value) {
      $query .= $pref . $key;
      $pref = ", ";
    }

    $query .= ") VALUES (";
    $pref = "";

    foreach($arr as $key => $value) {
      $query .= $pref . "'" . $value . "'";
      $pref = ", ";
    }

    $query .= ");";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  private function delete($table, $arr) {
    $query = "DELETE FROM " . $table;
    $pref = " WHERE ";

    foreach($arr as $key => $value) {
      $query .= $pref . $key . "='" . $value . "'";
      $pref = " AND ";
    }

    $query .= ";";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  private function exists($table, $arr) {
    $res = $this->select($table, $arr);
    
    return ($res->rowCount() > 0) ? true : false;
  }

  public function userForAuth($hash) {
    $query = "SELECT * FROM users JOIN (SELECT user_username FROM userauth WHERE hash = '" . $hash . "' LIMIT 1) AS UA WHERE users.user_username = UA.user_username LIMIT 1";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
      return $stmt->fetchObject();
    } else {
      return false;
    }
  }

  public function signupUser($user) {
    $emailCheck = $this->exists("users", array("user_email" => $user['user_email']));

    if($emailCheck) {
      return 1;
    } else {
      $userCheck = $this->exists("users", array("user_username" => $user['user_username']));

      if($userCheck) {
        return 2;
      } else {
        $this->insert("users", $user);
        $this->authorizeUser($user);

        return true;
      }
    }
  }

  public function authorizeUser($user) {
    $chars = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
    $hash = sha1($user['user_username']);

    for($i = 0; $i < 12; $i++) {
      $hash .= $chars[rand(0, 61)];
    }

    $this->insert("userauth", array("hash" => $hash, "user_username" => $user['user_username']));
    setCookie("Auth", $hash);
  }

  public function attemptLogin($userInfo) {
    if($this->exists("users", $userInfo['user_username'])) {
      $query = "SELECT * FROM users WHERE user_username = :user_username";
      $stmt = $this->db->prepare($query);
      $stmt->execute([':user_username' => $userInfo['user_username']]);

      $row = $stmt->fetch();
      $password = $row['user_password'];

      if(password_verify($userInfo['user_password'], $password)) {
        $this->authorizeUser($userInfo);

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function logoutUser($hash) {
    $this->delete("userauth", array("hash" => $hash));
    setCookie("Auth", "", time() - 3600);
  }

  public function getUserInfo($user) {
    $query = "SELECT post_count, IF(post_content IS NULL, 'You have no Posts', post_content) AS post_content, followers, following
      FROM (SELECT COUNT(*) AS post_count FROM posts WHERE post_by = " . $user->user_id . ") AS PC
      LEFT JOIN (SELECT * FROM posts WHERE post_by = " . $user->user_id . " ORDER BY post_date DESC LIMIT 1) AS P
      ON P.post_by = " . $user->user_id . " JOIN ( SELECT COUNT(*) AS followers FROM Follows WHERE followee_id = " . $user->user_id .
      ") AS FE JOIN (SELECT COUNT(*) AS following FROM Follows WHERE user_id = " . $user->user_id . ") AS FP;";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }

  public function getFollowersPosts($user) {
    $query = 
      "SELECT * FROM posts JOIN (SELECT * FROM users LEFT JOIN (SELECT followee_id FROM follows WHERE user_id = " .
      $user->user_id . " ) AS follows ON followee_id = user_id WHERE followee_id = user_id OR user_id = " . $user->user_id .
      ") AS users ON post_by = users.user_id ORDER BY posts.post_date DESC LIMIT 10;";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $followers_posts = $stmt->fetchAll();

    return $followers_posts;
  }

  public function newPost($user, $post_image = null) {
    $post = array(
      "post_title" => htmlentities($_POST['title']),
      "post_slug" => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', htmlentities($_POST['title'])))) . "-" . rand(0, 100),
      "post_image" => $post_image,
      "post_content" => htmlentities($_POST['content']),
      "post_date" => date('Y-m-d H:i:s'),
      "post_by" => $user->user_id
    );

    $this->insert("posts", $post);
  }

  public function getPublicPosts($q) {
    if($q === false) {
      $query = "SELECT * FROM posts JOIN users ON post_by = users.user_id ORDER BY posts.post_date DESC LIMIT 10;";
    } else {
      $query = "SELECT * FROM posts JOIN users ON post_by = users.user_id WHERE post_content LIKE \"%" . $q . "%\" ORDER BY posts.post_date DESC LIMIT 10;";
    }

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $posts = $stmt->fetchAll();

    return $posts;
  }

  public function getPost($postQuery) {
    $query = "SELECT * FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE post_slug = :post_slug";

    $stmt = $this->db->prepare($query);
    $stmt->execute([':post_slug' => $postQuery]);

    $post = $stmt->fetch();

    return $post;
  }

  public function updatePost($updateInfo) {
    $query = "UPDATE posts SET post_title = :post_title, post_slug = :new_slug, post_image = :post_image, post_content = :post_content WHERE post_slug = :current_slug";

    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ':current_slug' => $updateInfo['current_slug'],
      ':post_title' => $updateInfo['post_title'],
      ':new_slug' => $updateInfo['post_slug'],
      ':post_image' => $updateInfo['post_image'],
      ':post_content' => $updateInfo['post_content']
    ]);

    return $stmt;
  }

  public function deletePost($post) {
    $post_data = $this->select("posts", array("post_slug" => $post));
    $post_info = $post_data->fetch();

    $delete_dir = "uploads/";
    $image = $post_info['post_image'];
    $file = $delete_dir . $image;

    if(file_exists($file)) {
      unlink($file);
    }

    $this->delete("posts", array("post_slug" => $post));

    return true;
  }

  public function newComment($commentInfo) {
    $this->insert("comments", $commentInfo);

    return true;
  }

  public function getComments($post) {
    $query = "SELECT * FROM comments LEFT JOIN users ON comments.comment_by = users.user_id WHERE comment_post = :post_id ORDER BY comment_date DESC";

    $stmt = $this->db->prepare($query);
    $stmt->execute([':post_id' => $post]);

    $comments = $stmt->fetchAll();

    return $comments;
  }

  public function getPublicProfiles($user, $q) {
    if($q === false) {
      $query = "SELECT * FROM users WHERE user_id != " . $user->user_id . " ORDER BY user_joined DESC LIMIT 10";
    } else {
      $query = "SELECT * FROM users WHERE user_id != " . $user->user_id . " AND (user_name LIKE \"%" . $q . "%\" OR user_username LIKE \"%" . $q . "%\") ORDER BY user_joined DESC LIMIT 10";
    }

    $res = $this->db->prepare($query);
    $res->execute();

    if($res->rowCount() > 0) {
      $userArr = array();
      $query = "";

      while($row = $res->fetch()) {
        $user_id = $row['user_id'];

        $query .= "SELECT " . $user_id . " AS user_id, followers, IF(post_title IS NULL, 'This user has no posts.', post_title)
          AS post_title, followed FROM (SELECT COUNT(*) AS followers FROM follows WHERE followee_id = " . $user_id . ")
          AS F LEFT JOIN (SELECT * FROM posts WHERE post_by = " . $user_id .
          " ORDER BY post_date DESC LIMIT 1) AS P ON P.post_by = " . $user_id . " JOIN (SELECT COUNT(*)
          AS followed FROM follows WHERE followee_id = " . $user_id . " AND user_id = " . $user->user_id . ") AS F2 LIMIT 1;";

        $userArr[$user_id] = $row;
      }

      $stmt = $this->db->prepare($query);
      $stmt->execute();

      $profiles = array();

      do {
        $row = $stmt->fetch();
        $user_id = $row['user_id'];
        $userArr[$user_id]['followers'] = $row['followers'];
        $userArr[$user_id]['followed'] = $row['followed'];
        $userArr[$user_id]['post_title'] = $row['post_title'];

        array_push($profiles, $userArr[$user_id]);
      } while($stmt->nextRowset());

      return $profiles;
    } else {
      return null;
    }
  }

  public function getProfile($user, $profile) {
    $query = "SELECT * FROM users WHERE user_username = :user_username;";

    $stmt = $this->db->prepare($query);
    $stmt->execute([':user_username' => $profile]);

    if($stmt->rowCount() > 0) {
      $user = $stmt->fetch();

      return $user;
    } else {
      return null;
    }
  }

  public function getProfileInfo($user, $profile) {
    $query = "SELECT post_count, IF(post_title IS NULL, 'You have no Posts', post_title) AS post_title, followers, following, followed
      FROM (SELECT COUNT(*) AS post_count FROM posts WHERE post_by = " . $profile . ") AS PC
      LEFT JOIN (SELECT * FROM posts WHERE post_by = " . $profile . " ORDER BY post_date DESC LIMIT 1) AS P
      ON P.post_by = " . $profile . " JOIN ( SELECT COUNT(*) AS followers FROM Follows WHERE followee_id = " . $profile .
      ") AS FE JOIN (SELECT COUNT(*) AS following FROM Follows WHERE user_id = " . $profile . ") AS FP
      JOIN (SELECT COUNT(*) AS followed FROM Follows WHERE followee_id = " . $profile . " AND user_id = " . $user->user_id . ") AS F2;";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }

  public function getUsersPosts($user_id) {
    $query = "SELECT * FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_by = :user_id ORDER BY posts.post_date DESC";

    $stmt = $this->db->prepare($query);
    $stmt->execute([':user_id' => $user_id]);

    $posts = $stmt->fetchAll();

    return $posts;
  }

  public function updateInfo($user, $userInfo) {
    if($this->exists("users", array("user_username" => $user['user_username'])) && $user['user_username'] !== $userInfo['user_username']) {
      return 4;
    } else {
      if($this->exists("users", array("user_email" => $user['user_email'])) && $user['user_email'] !== $userInfo['user_email']) {
        return 5;
      } else {
        $query = "UPDATE users SET user_name = :user_name, user_username = :user_username, user_email = :user_email WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
          ':user_id' => $user['user_id'],
          ':user_name' => $user['user_name'],
          ':user_username' => $user['user_username'],
          ':user_email' => $user['user_email']
        ]);

        $this->authorizeUser($user);

        return true;
      }
    }
  }

  public function editProfilePicture($profile_picture) {
    $query = "UPDATE users SET user_profile_picture = :user_profile_picture WHERE user_id = :user_id";

    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ':user_id' => $profile_picture['user_id'],
      ':user_profile_picture' => $profile_picture['user_profile_picture']
    ]);

    return true;
  }

  public function changePassword($passwordInfo) {
    $query = "UPDATE users SET user_password = :user_password WHERE user_id = :user_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ':user_id' => $passwordInfo['user_id'],
      ':user_password' => $passwordInfo['password']
    ]);

    return true;
  }

  public function deleteProfile($user) {
    $this->delete("users", array("user_id" => $user->user_id));

    return true;
  }

  public function follow($user, $fId) {
    $this->insert("follows", array("user_id" => $user->user_id, "followee_id" => $fId));
  }

  public function unfollow($user, $fId) {
    $this->delete("follows", array("user_id" => $user->user_id, "followee_id" => $fId));
  }
}