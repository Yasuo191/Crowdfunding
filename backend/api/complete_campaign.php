<?php
require_once "../config/database.php";
require_once "../controllers/CampaignController.php";

(new CampaignController($pdo))->complete();