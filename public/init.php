<?php
require_once "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 'On');

spl_autoload_register(function($class) {
  include_once "classes/" . $class . ".php";
});

$database = new Database();
$newDB = $database->DB();

session_start();