<?php

require_once "../controllers/DonationController.php";
require_once "../config/database.php";
$controller = new DonationController($pdo);

$controller->adminDonations();