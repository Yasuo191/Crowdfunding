<?php

require_once "../config/database.php";
require_once "../services/CampaignService.php";

class CampaignController
{
    private CampaignService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new CampaignService($pdo);
    }

    /**
     * Hàm trợ giúp kiểm tra đăng nhập và trả về JSON chuẩn
     */
    private function checkAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["message" => "Bạn chưa đăng nhập"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    /**
     * Tạo chiến dịch mới
     */
    public function create()
    {
        $this->checkAuth();

        header("Content-Type: application/json; charset=UTF-8");

        $result = $this->service->createCampaign(
            $_SESSION["user_id"],
            $_POST["title"] ?? null,
            $_POST["description"] ?? null,
            $_POST["target_amount"] ?? 0,
            $_POST["start_date"] ?? null,
            $_POST["end_date"] ?? null
        );

        if ($result === true) {
            echo json_encode(["message" => "Tạo chiến dịch thành công"], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode(["message" => $result], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Danh sách toàn bộ chiến dịch (Đầu ra JSON)
     */
    public function index()
    {
        $campaigns = $this->service->getAllCampaigns();

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($campaigns, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Chi tiết chiến dịch theo ID (Đầu ra JSON)
     */
    public function show($id)
    {
        $campaign = $this->service->getCampaignById($id);

        header("Content-Type: application/json; charset=UTF-8");

        if ($campaign) {
            echo json_encode($campaign, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Không tìm thấy chiến dịch"], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Cập nhật thông tin chiến dịch
     */
    public function update()
    {
        $this->checkAuth();

        header("Content-Type: application/json; charset=UTF-8");

        $result = $this->service->updateCampaign(
            $_POST["id"] ?? null,
            $_SESSION["user_id"],
            $_POST["title"] ?? null,
            $_POST["description"] ?? null,
            $_POST["target_amount"] ?? 0,
            $_POST["start_date"] ?? null,
            $_POST["end_date"] ?? null
        );

        if ($result === true) {
            echo json_encode(["message" => "Cập nhật chiến dịch thành công"], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode(["message" => $result], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Xóa mềm chiến dịch
     */
    public function delete()
    {
        $this->checkAuth();

        header("Content-Type: application/json; charset=UTF-8");

        $result = $this->service->deleteCampaign(
            $_POST["id"] ?? null,
            $_SESSION["user_id"],
            $_SESSION["role"] ?? "user"
        );

        if ($result === true) {
            echo json_encode(["message" => "Xóa chiến dịch thành công"], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode(["message" => $result], JSON_UNESCAPED_UNICODE);
        }
    }
}