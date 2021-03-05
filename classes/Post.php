<?php
class Post {
  private $db;

  public $id;
  public $name;
  public $username;
  public $title;
  public $image;
  public $content;

  public function __construct($newDB) {
    $this->db = $newDB;
  }

  function createPost() {
    $sql = "INSERT INTO posts (name, username, title, image, content) VALUES (:name, :username, :title, :image, :content)";
    $stmt = $this->db->prepare($sql);

    $this->name = $_SESSION['name'];
    $this->username = $_SESSION['username'];
    $this->title = htmlentities($this->title);
    $this->image = $this->image;
    $this->content = htmlentities($this->content);

    if($stmt->execute([
      ':name' => $this->name,
      ':username' => $this->username,
      ':title' => $this->title,
      ':image' => $this->image,
      ':content' => $this->content,
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function readPosts() {
    $sql = "SELECT * FROM posts WHERE username = :username ORDER BY id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':username' => $this->username]);

    return $stmt;
  }

  function readSinglePost() {
    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $this->id]);

    return $stmt;
  }

  function updatePost() {
    $sql = "UPDATE posts SET title = :title, image = :image, content = :content WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    $this->id = $this->id;
    $this->title = htmlentities($this->title);
    $this->image = $this->image;
    $this->content = htmlentities($this->content);

    $stmt->execute([
      ':id' => $this->id,
      ':title' => $this->title,
      ':image' => $this->image,
      ':content' => $this->content
    ]);

    return $stmt;
  }

  function deletePost() {
    $sql = "DELETE FROM posts WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':id' => $this->id])) {
      return true;
    } else {
      return false;
    }
  }
}