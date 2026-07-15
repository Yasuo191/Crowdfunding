<?php
require_once "../config/database.php";
require_once "../controllers/CampaignController.php";

$controller = new CampaignController($pdo);

// Gọi trực tiếp hàm update() của controller
$controller->update();
