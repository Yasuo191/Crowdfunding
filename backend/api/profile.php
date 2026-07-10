<?php

require_once "../config/database.php";

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["user_id"])) {

    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Chưa đăng nhập"
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

echo json_encode([
    "success" => true,
    "user" => [
        "id" => $_SESSION["user_id"],
        "username" => $_SESSION["username"] ?? "",
        "email" => $_SESSION["email"] ?? "",
        "role" => $_SESSION["role"]
    ]
], JSON_UNESCAPED_UNICODE);