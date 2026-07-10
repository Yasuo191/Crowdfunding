<?php
// 1. Cấu hình CORS để cho phép Frontend (Vite) truy cập API
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Xử lý các yêu cầu Preflight (OPTIONS request)
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204); // Trả về mã 204 No Content chuẩn cho OPTIONS
    exit;
}

// 2. Cấu hình thông tin cơ sở dữ liệu
$host = "localhost";
$dbname = "crowdfunding_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Cấu hình chế độ ném ngoại lệ khi gặp lỗi SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mặc định trả về dữ liệu dạng mảng kết hợp (Associative Array)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(500);
    echo json_encode([
        "message" => "Lỗi kết nối cơ sở dữ liệu hệ thống",
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
