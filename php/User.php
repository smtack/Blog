<?php
class User {
  private $db;
  private $table_name = "users";

  public $name;
  public $email;
  public $password;

  public function __construct($newDB) {
    $this->db = $newDB;
  }

  function signup() {
    $query = "INSERT INTO " . $this->table_name . " (name, username, email, password) VALUES (:name, :username, :email, :password)";

    $stmt = $this->db->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));

    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

    if ($stmt->execute([
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
    $query = "SELECT name, username, email, password FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";

    $stmt = $this->db->prepare($query);

    $this->email = htmlspecialchars(strip_tags($this->email));

    $stmt->execute([
      ':email' => $this->email
    ]);

    $num = $stmt->rowCount();

    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->username = $row['username'];
      $this->password = $row['password'];

      return true;
    }

    return false;
  }

  function readUsers() {
    $query = "SELECT * FROM " . $this->table_name . " ORDER BY id";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
  }
}
?>
