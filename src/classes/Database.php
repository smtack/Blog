<?php
class Database {
  private $dbhost = DB_HOST;
  private $dbname = DB_NAME;
  private $dbuser = DB_USER;
  private $dbpass = DB_PASS;
  private $dbchar = DB_CHARSET;

  public $db;
  public $dsn;
  public $opt;

  public function DB() {
    $this->db = null;

    $this->dsn = 'mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname . ';charset=' . $this->dbchar;

    $this->opt = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false
    ];

    try {
      $this->db = new PDO($this->dsn, $this->dbuser, $this->dbpass, $this->opt);
    } catch(PDOException $e) {
      die($e->getMessage());
    }

    return $this->db;
  }
}