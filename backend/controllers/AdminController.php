<?php

require_once "../config/database.php";
require_once "../services/AdminService.php";

class AdminController
{
    private AdminService $service;

    public function __construct(PDO $pdo)
    {
        session_start();

        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] != "admin"
        ) {
            http_response_code(403);
            die("Chỉ Admin được phép truy cập");
        }

        $this->service = new AdminService($pdo);
    }

    public function pending()
    {
        header("Content-Type: application/json");

        echo json_encode(
            $this->service->getPendingCampaigns(),
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE
        );
    }

    public function approve()
    {
        echo $this->service->approveCampaign(
            $_POST["id"]
        )
        ? "Duyệt thành công"
        : "Lỗi";
    }

    public function reject()
    {
        echo $this->service->rejectCampaign(
            $_POST["id"]
        )
        ? "Đã từ chối"
        : "Lỗi";
    }
}