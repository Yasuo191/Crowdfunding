<?php

require_once "../config/database.php";
require_once "../services/DonationService.php";

class DonationController
{
    private DonationService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new DonationService($pdo);
    }

    /**
     * Thực hiện hành động quyên góp tiền
     */
    public function donate()
    {
        session_start();

        if (!isset($_SESSION["user_id"])) {
            die("Bạn chưa đăng nhập");
        }

        $campaignId = $_POST["campaign_id"];
        $amount = $_POST["amount"];
        $message = $_POST["message"];

        $result = $this->service->donate(
            $_SESSION["user_id"],
            $campaignId,
            $amount,
            $message
        );

        if ($result === true) {
            echo "Quyên góp thành công";
        } else {
            echo $result;
        }
    }

    /**
     * Xem lịch sử quyên góp của người dùng hiện tại (Đầu ra JSON)
     */
    public function history()
    {
        session_start();

        if (!isset($_SESSION["user_id"])) {
            die("Bạn chưa đăng nhập");
        }

        $history = $this->service->getUserDonations($_SESSION["user_id"]);

        header("Content-Type: application/json; charset=UTF-8");

        echo json_encode(
            $history,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }
}