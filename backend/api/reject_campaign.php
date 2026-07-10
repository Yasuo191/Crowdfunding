<?php
require_once "../config/database.php";
require_once "../controllers/AdminController.php";
(new AdminController($pdo))->reject();