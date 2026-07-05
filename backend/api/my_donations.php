<?php

require_once "../controllers/DonationController.php";

$controller = new DonationController($pdo);

$controller->history();