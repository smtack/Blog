<?php
class Post {
  private $db;

  public $post_id;
  public $post_title;
  public $post_image;
  public $post_content;

  public function __construct($db) {
    $this->db = $db;
  }

  function createPost() {
    $sql = "INSERT INTO posts (post_title, post_image, post_content, post_date, post_by) VALUES (:post_title, :post_image, :post_content, NOW(), :post_by)";
    $stmt = $this->db->prepare($sql);

    $this->post_title = htmlentities($_POST['title']);
    $this->post_image = $this->post_image;
    $this->post_content = htmlentities($_POST['content']);

    if($stmt->execute([
      ':post_title' => $this->post_title,
      ':post_image' => $this->post_image,
      ':post_content' => $this->post_content,
      ':post_by' => $_SESSION['user_id']
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function readPosts() {
    $sql = "SELECT * FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_by = :user_id ORDER BY post_id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':user_id' => $_SESSION['user_id']]);

    return $stmt;
  }

  function readUsersPosts() {
    $sql = "SELECT * FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_by = :user_id ORDER BY post_id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':user_id' => htmlentities($_GET['id'])]);

    return $stmt;
  }

  function readSinglePost() {
    $sql = "SELECT * FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE post_id = :post_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':post_id' => htmlentities($_GET['id'])]);

    return $stmt;
  }

  function updatePost() {
    $sql = "UPDATE posts SET post_title = :post_title, post_image = :post_image, post_content = :post_content WHERE post_id = :post_id";
    $stmt = $this->db->prepare($sql);

    $this->post_title = htmlentities($_POST['title']);
    $this->post_image = $this->post_image;
    $this->post_content = htmlentities($_POST['content']);

    if($stmt->execute([
      ':post_id' => htmlentities($_GET['id']),
      ':post_title' => $this->post_title,
      ':post_image' => $this->post_image,
      ':post_content' => $this->post_content
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function deletePost() {
    $sql = "DELETE FROM posts WHERE post_id = :post_id";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':post_id' => htmlentities($_GET['id'])])) {
      return true;
    } else {
      return false;
    }
  }
}