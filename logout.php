<?php
include_once "src/init.php";

session_destroy();

header("Location: index");