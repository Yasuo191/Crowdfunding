<?php

require_once "../controllers/CampaignController.php";

$controller = new CampaignController($pdo);
$controller->delete();