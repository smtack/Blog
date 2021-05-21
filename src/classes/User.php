<?php
class User {
  private $db;
  
  public $user_name;
  public $user_username;
  public $user_email;
  public $user_password;
  public $user_profile_picture;

  public function __construct($db) {
    $this->db = $db;
  }

  function signUp() {
    $sql = "INSERT INTO users (user_name, user_username, user_email, user_password, user_joined) VALUES (:user_name, :user_username, :user_email, :user_password, NOW())";
    $stmt = $this->db->prepare($sql);

    $this->user_name = htmlentities($_POST['name']);
    $this->user_username = htmlentities($_POST['username']);
    $this->user_email = htmlentities($_POST['email']);
    $this->user_password = htmlentities($_POST['password']);

    $password_hash = password_hash($this->user_password, PASSWORD_BCRYPT);

    if($stmt->execute([
      ':user_name' => $this->user_name,
      ':user_username' => $this->user_username,
      ':user_email' => $this->user_email,
      ':user_password' => $password_hash
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function logIn() {
    $sql = "SELECT * FROM users WHERE user_username = :user_username LIMIT 0,1";
    $stmt = $this->db->prepare($sql);

    $this->user_username = htmlentities($_POST['username']);

    $stmt->execute([':user_username' => $this->user_username]);

    $rows = $stmt->rowCount();

    if($rows > 0) {
      $row = $stmt->fetch();
      
      $this->user_id = $row['user_id'];
      $this->user_name = $row['user_name'];
      $this->user_username = $row['user_username'];
      $this->user_email = $row['user_email'];
      $this->user_password = $row['user_password'];

      return true;
    } else {
      return false;
    }
  }

  function logOut() {
    session_destroy();

    return false;
  }

  function getUser() {
    $sql = "SELECT * FROM users WHERE user_username = :user_username";
    $stmt = $this->db->prepare($sql);

    $stmt->execute([':user_username' => $_SESSION['username']]);

    return $stmt;
  }

  function updateProfilePicture() {
    $sql = "UPDATE users SET user_profile_picture = :user_profile_picture WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    
    if($stmt->execute([
      ':user_id' => htmlentities($_GET['id']),
      ':user_profile_picture' => $this->user_profile_picture
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function updateUser() {
    $sql = "UPDATE users SET user_name = :user_name, user_email = :user_email WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);

    $this->user_name = htmlentities($_POST['name']);
    $this->user_email = htmlentities($_POST['email']);

    if($stmt->execute([
      ':user_id' => htmlentities($_GET['id']),
      ':user_name' => $this->user_name,
      ':user_email' => $this->user_email
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function changePassword() {
    $sql = "UPDATE users SET user_password = :user_password WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);

    $this->user_password = htmlentities($_POST['new_password']);

    $password_hash = password_hash($this->user_password, PASSWORD_BCRYPT);

    if($stmt->execute([
      ':user_id' => htmlentities($_GET['id']),
      ':user_password' => $password_hash
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function deleteUser() {
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':user_id' => htmlentities($_GET['id'])])) {
      return true;
    } else {
      return false;
    }
  }

  function getUserProfile() {
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $this->db->prepare($sql);

    $this->user_id = htmlentities($_GET['id']);

    $stmt->execute([":user_id" => $this->user_id]);

    return $stmt;
  }

  function searchUsers($keywords) {
    $sql = "SELECT * FROM users WHERE user_name LIKE ? OR user_username LIKE ? ORDER BY user_id DESC";
    $stmt = $this->db->prepare($sql);

    $keywords = htmlentities($keywords);
    $keywords = "%{$keywords}%";

    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);

    $stmt->execute();

    return $stmt;
  }
}