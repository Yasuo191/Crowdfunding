<?php
require_once "../controllers/CampaignController.php";
if (!isset($_GET["id"])) {
    die("Thiếu ID chiến dịch");
}
$controller = new CampaignController($pdo);
$controller->show($_GET["id"]);