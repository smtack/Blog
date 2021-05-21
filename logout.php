<?php
require_once "src/init.php";

$user = new User($db);

$user->logOut();

header("Location: " . BASE_URL);