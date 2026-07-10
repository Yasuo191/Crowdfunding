<?php
require_once "../config/database.php";
require_once "../services/DashboardService.php";

class DashboardController
{
    private DashboardService $service;

    public function __construct(PDO $pdo)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode([
                "success"=>false,
                "message"=>"Bạn chưa đăng nhập"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if ($_SESSION["role"] !== "admin") {
            http_response_code(403);
            echo json_encode([
                "success"=>false,
                "message"=>"Quyền truy cập bị từ chối. Chỉ Admin mới có quyền vào khu vực này"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $this->service = new DashboardService($pdo);
    }

    public function index()
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(
            $this->service->statistics(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }
}
