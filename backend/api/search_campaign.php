<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "../config/database.php";
require_once "../controllers/CampaignController.php";

$controller = new CampaignController($pdo);
$controller->search();