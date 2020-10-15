<?php
class Post {
  private $db;
  private $table_name = "posts";

  public $id;
  public $title;
  public $content;
  public $datetime;
  public $name;

  public function __construct($newDB) {
    $this->db = $newDB;
  }

  function create() {
    $query = "INSERT INTO " . $this->table_name . "(title, content, name, username, email) VALUES (:title, :content, :name, :username, :email)";
    $stmt = $this->db->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->content = htmlspecialchars(strip_tags($this->content));
    $this->name = htmlspecialchars(strip_tags($_SESSION['name']));
    $this->username = htmlspecialchars(strip_tags($_SESSION['username']));
    $this->email = htmlspecialchars(strip_tags($_SESSION['email']));

    if ($stmt->execute([
      ":title" => $this->title,
      ":content" => $this->content,
      ":name" => $this->name,
      ":username" => $this->username,
      ":email" => $this->email
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function read() {
    $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email ORDER BY id DESC";

    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ':email' => $_SESSION['email']
    ]);

    return $stmt;
  }

  function readOne() {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";

    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ":id" => $this->id
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->title = $row['title'];
    $this->content = $row['content'];
    $this->name = $row['name'];
    $this->username = $row['username'];
    $this->datetime = $row['datetime'];
  }

  function readUsersPosts() {
    $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username ORDER BY id DESC";

    $stmt = $this->db->prepare($query);
    $stmt->execute([
      ':username' => $this->username
    ]);

    return $stmt;
  }

  function update() {
    $query = "UPDATE " . $this->table_name . " SET title = :title, content = :content, name = :name, username = :username WHERE id = :id";

    $stmt = $this->db->prepare($query);

    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->content = htmlspecialchars(strip_tags($this->content));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->id = htmlspecialchars(strip_tags($this->id));

    if ($stmt->execute([
      ":title" => $this->title,
      ":content" => $this->content,
      ":name" => $this->name,
      ":username" => $this->username,
      ":id" => $this->id
    ])) {
      return true;
    }

    return false;
  }

  function delete() {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

    $stmt = $this->db->prepare($query);

    if ($stmt->execute([
      ":id" => $this->id
      ])) {
        return true;
    } else {
      return false;
    }
  }

  function search($keywords) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE title LIKE ? OR content LIKE ? ORDER BY id DESC";

    $stmt = $this->db->prepare($query);

    $keywords = htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);

    $stmt->execute();

    return $stmt;
  }
}
?>
