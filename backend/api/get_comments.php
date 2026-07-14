<?php

require_once "../config/database.php";
require_once "../controllers/CommentController.php";

$controller = new CommentController($pdo);

$controller->index();