<?php

require_once "../controllers/CampaignController.php";
require_once "../config/database.php";
(new CampaignController($pdo))->restore();