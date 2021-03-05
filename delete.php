<?php
require_once "public/init.php";

$id = isset($_GET['id']) ? $_GET['id'] : die("No ID");

$user = new User($newDB);

$user->id = $id;

if($user->deleteUser()) {
  header("Location: " . BASE_URL . "/index");
} else {
  echo "Unable to delete user.";
}