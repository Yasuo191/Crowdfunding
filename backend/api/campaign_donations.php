<?php
require_once "../config/database.php";
require_once "../controllers/DonationController.php";
(new DonationController($pdo))->campaignDonations();