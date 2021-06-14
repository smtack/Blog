<?php
class Flash {
  public $msg;
  public $type;

  function __construct($msg, $type) {
    $this->msg = $msg;
    $this->type = $type;
  }

  public function display() {
    echo "<div class=\"flash " . $this->type . "\">" . $this->msg . "</div>";
  }
}