<?php
class User {
  private $db;
  
  public $name;
  public $username;
  public $email;
  public $password;

  public function __construct($newDB) {
    $this->db = $newDB;
  }

  function signUp() {
    $sql = "INSERT INTO users (name, username, email, password) VALUES (:name, :username, :email, :password)";
    $stmt = $this->db->prepare($sql);

    $this->name = htmlentities($this->name);
    $this->username = htmlentities($this->username);
    $this->email = htmlentities($this->email);
    $this->password = htmlentities($this->password);

    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

    if($stmt->execute([
      ':name' => $this->name,
      ':username' => $this->username,
      ':email' => $this->email,
      ':password' => $password_hash
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function checkUser() {
    $sql = "SELECT * FROM users WHERE username = :username LIMIT 0,1";
    $stmt = $this->db->prepare($sql);

    $this->username = htmlentities($this->username);

    $stmt->execute([':username' => $this->username]);

    $num = $stmt->rowCount();

    if($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->username = $row['username'];
      $this->email = $row['email'];
      $this->password = $row['password'];

      return true;
    }

    return false;
  }

  function updateUser() {
    $sql = "UPDATE users SET name = :name, username = :username, email = :email WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    $this->id = $this->id;
    $this->name = htmlentities($this->name);
    $this->username = htmlentities($this->username);
    $this->email = htmlentities($this->email);

    if($stmt->execute([
      ':id' => $this->id,
      ':name' => $this->name,
      ':username' => $this->username,
      ':email' => $this->email
    ])) {
      return true;
    }

    return false;
  }

  function changePassword() {
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    $this->id = $this->id;
    $this->password = htmlentities($this->password);

    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

    if($stmt->execute([
      ':id' => $this->id,
      ':password' => $password_hash
    ])) {
      return true;
    }

    return false;
  }

  function logOut() {
    session_destroy();

    return false;
  }

  function deleteUser() {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':id' => $this->id])) {
      return true;
    } else {
      return false;
    }
  }

  function getSingleUser() {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $this->db->prepare($sql);

    $this->username = $_SESSION['username'];

    $stmt->execute([':username' => $this->username]);

    return $stmt;
  }

  function getUserProfile() {
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    $this->id = htmlentities($_GET['id']);

    $stmt->execute(["id" => $this->id]);

    return $stmt;
  }

  function searchUsers($keywords) {
    $sql = "SELECT * FROM users WHERE name LIKE ? OR username LIKE ? ORDER BY id DESC";
    $stmt = $this->db->prepare($sql);

    $keywords = htmlentities($keywords);
    $keywords = "%{$keywords}%";

    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);

    $stmt->execute();

    return $stmt;
  }
}