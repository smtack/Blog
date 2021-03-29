<?php
require_once "public/init.php";

$user = new User($newDB);

$keywords = isset($_GET['search']) ? $_GET['search'] : '';

$search = $user->searchUsers($keywords);
$results = $search->fetchAll();

$page_title = "Blog - Search: " . $keywords;

require VIEW_ROOT . "/search.php";