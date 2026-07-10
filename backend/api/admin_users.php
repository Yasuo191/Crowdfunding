<?php

require_once "../controllers/UserController.php";

$controller = new UserController($pdo);
require_once "../config/database.php";
$controller->index();