<?php
require_once "../config/database.php";
session_start();

session_unset();

session_destroy();

// Thiết lập header báo cho client biết đây là dữ liệu JSON
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    "success" => true,
    "message" => "Đăng xuất thành công"
], JSON_UNESCAPED_UNICODE);

exit();