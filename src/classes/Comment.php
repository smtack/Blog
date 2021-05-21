<?php
class Comment {
  private $db;

  public $comment_text;

  public function __construct($db) {
    $this->db = $db;
  }

  function postComment() {
    $sql = "INSERT INTO comments (comment_text, comment_date, comment_post, comment_by) VALUES (:comment_text, NOW(), :comment_post, :comment_by)";
    $stmt = $this->db->prepare($sql);

    $this->comment_text = htmlentities($_POST['comment_text']);

    if($stmt->execute([
      ':comment_text' => $this->comment_text,
      ':comment_post' => htmlentities($_GET['id']),
      ':comment_by' => $_SESSION['user_id']
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function getComments() {
    $sql = "SELECT * FROM comments LEFT JOIN users ON comments.comment_by = users.user_id WHERE comment_post = :post_id ORDER BY comment_id DESC";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':post_id' => htmlentities($_GET['id'])])) {
      return $stmt;
    } else {
      return false;
    }
  }
}