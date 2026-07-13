<?php

require_once "../services/FinancialReportService.php";

class FinancialReportController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new FinancialReportService($pdo);
    }

    public function create()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Bạn chưa đăng nhập"
            ], JSON_UNESCAPED_UNICODE);

            exit;
        }

        $campaignId = $_POST["campaign_id"] ?? null;
        $income     = $_POST["income"] ?? 0;
        $expense    = $_POST["expense"] ?? 0;
        $note       = $_POST["note"] ?? "";

        $result = $this->service->create(
            $campaignId,
            $_SESSION["user_id"],
            $income,
            $expense,
            $note
        );

        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Tạo báo cáo thành công"
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Không thể tạo báo cáo"
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function index()
    {
        header("Content-Type: application/json; charset=UTF-8");

        echo json_encode(
            $this->service->getAll(),
            JSON_UNESCAPED_UNICODE
        );
    }

    public function byCampaign()
    {
        header("Content-Type: application/json; charset=UTF-8");

        $campaignId = $_GET["campaign_id"] ?? 0;

        echo json_encode(
            $this->service->getByCampaign($campaignId),
            JSON_UNESCAPED_UNICODE
        );
    }
}