<?php

require_once "../controllers/AdminController.php";

(new AdminController($pdo))->pending();