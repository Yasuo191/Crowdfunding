<?php

session_start();

require_once "../config/database.php";
require_once "../controllers/FinancialReportController.php";

$controller = new FinancialReportController($pdo);

$controller->index();