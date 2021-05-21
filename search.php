<?php
require_once "src/init.php";

$user = new User($db);

$get_user_data = $user->getUser();
$user_data = $get_user_data->fetch();

$keywords = isset($_GET['search']) ? $_GET['search'] : '';

$search = $user->searchUsers($keywords);
$results = $search->fetchAll();

$page_title = "Blog - Search: " . $keywords;

require VIEW_ROOT . "/search.php";