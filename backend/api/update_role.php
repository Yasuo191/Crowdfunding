<?php

require_once "../controllers/UserController.php";
require_once "../config/database.php";
$controller = new UserController($pdo);

$controller->updateRole();