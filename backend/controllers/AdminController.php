<?php

require_once "../config/database.php";
require_once "../services/AdminService.php";

class AdminController
{
    private AdminService $service;

    public function __construct(PDO $pdo)
    {
        // Khởi tạo session nếu chưa được khởi tạo trước đó
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Đặt Header mặc định cho toàn bộ Controller là JSON
        header("Content-Type: application/json; charset=utf-8");

        if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
            http_response_code(403);
            echo json_encode([
                "success" => false,
                "message" => "Chỉ Admin được phép truy cập"
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        $this->service = new AdminService($pdo);
    }

    public function pending()
    {
        // Header đã được set ở __construct, chỉ cần set mã 200 và trả dữ liệu
        http_response_code(200);
        echo json_encode(
            $this->service->getPendingCampaigns(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        exit;
    }

    public function approve()
    {
        if (!isset($_POST["id"])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Thiếu ID chiến dịch"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $result = $this->service->approveCampaign($_POST["id"]);

        if ($result) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Duyệt chiến dịch thành công"
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500); // Hoặc 400 tùy thuộc vào loại lỗi của service
            echo json_encode([
                "success" => false,
                "message" => "Lỗi khi duyệt chiến dịch"
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    public function reject()
    {
        if (!isset($_POST["id"])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Thiếu ID chiến dịch"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $result = $this->service->rejectCampaign($_POST["id"]);

        if ($result) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Đã từ chối chiến dịch"
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Lỗi khi từ chối chiến dịch"
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}