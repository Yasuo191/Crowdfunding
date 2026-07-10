<?php
require_once "../config/database.php";
require_once "../controllers/DashboardController.php";
(new DashboardController($pdo))->index();