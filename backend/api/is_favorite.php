<?php

session_start();

require_once "../config/database.php";
require_once "../controllers/FavoriteController.php";

$controller = new FavoriteController($pdo);

$controller->isFavorite();