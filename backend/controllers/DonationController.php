<?php
require_once "../config/database.php";
require_once "../services/DonationService.php";

class DonationController
{
    private DonationService $service;

    public function __construct(PDO $pdo)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->service = new DonationService($pdo);
    }

    public function donate()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["success"=>false,"message"=>"Bạn chưa đăng nhập"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $campaignId = $_POST["campaign_id"] ?? null;
        $amount     = $_POST["amount"] ?? 0;
        $message    = $_POST["message"] ?? "";

        $result = $this->service->donate($_SESSION["user_id"], $campaignId, $amount, $message);

        if ($result === true) {
            echo json_encode(["success"=>true,"message"=>"Quyên góp thành công"], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode(["success"=>false,"message"=>$result], JSON_UNESCAPED_UNICODE);
        }
    }

    public function history()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["success"=>false,"message"=>"Bạn chưa đăng nhập"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(
            $this->service->getUserDonations($_SESSION["user_id"]),
            JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE
        );
    }

    public function campaignDonations()
    {
        header("Content-Type: application/json; charset=UTF-8");
        $campaignId = $_GET["id"] ?? null;

        echo json_encode(
            $this->service->getCampaignDonations($campaignId),
            JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE
        );
    }

    public function adminDonations()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode(["success"=>false,"message"=>"Bạn chưa đăng nhập"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if ($_SESSION["role"] !== "admin") {
            http_response_code(403);
            echo json_encode(["success"=>false,"message"=>"Bạn không có quyền truy cập chức năng này"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(
            $this->service->getAllDonations(),
            JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE
        );
    }
}
