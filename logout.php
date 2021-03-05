<?php
require_once "public/init.php";

$user = new User($newDB);
$user->logOut();

header("Location: " . BASE_URL . "/index");