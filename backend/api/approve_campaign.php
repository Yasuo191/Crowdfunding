<?php
require_once "../controllers/AdminController.php";
require_once "../config/database.php";
(new AdminController($pdo))->approve();