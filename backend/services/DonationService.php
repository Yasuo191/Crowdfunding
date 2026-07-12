<?php

require_once "../models/Donation.php";
require_once "../models/Campaign.php";

class DonationService
{
    private Donation $donation;
    private Campaign $campaign;
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->donation = new Donation($pdo);
        $this->campaign = new Campaign($pdo);
    }

    /**
     * Xử lý nghiệp vụ quyên góp tiền (Đảm bảo tính toàn vẹn qua Transaction)
     */
public function donate(
    $userId,
    $campaignId,
    $amount,
    $message
) {
    if ($amount <= 0) {
        return "Số tiền phải lớn hơn 0";
    }

    // Kiểm tra chiến dịch
    $campaign = $this->campaign->getById($campaignId);

    if (!$campaign) {
        return "Chiến dịch không tồn tại";
    }

    if ($campaign["status"] === "completed") {
        return "Chiến dịch đã hoàn thành";
    }

    if ($campaign["status"] === "deleted") {
        return "Chiến dịch đã bị ẩn";
    }

    try {
        $this->pdo->beginTransaction();

        // Tạo bản ghi quyên góp
        $this->donation->create(
            $userId,
            $campaignId,
            $amount,
            $message
        );

        // Cập nhật số tiền của chiến dịch
        $this->donation->updateCampaignAmount(
            $campaignId,
            $amount
        );

        // Lấy lại dữ liệu sau khi đã update
        $campaign = $this->campaign->getById($campaignId);

        // Tính tổng mới
        $newAmount = $campaign["current_amount"];

        // Nếu đạt hoặc vượt mục tiêu thì đánh dấu hoàn thành
        if ($newAmount >= $campaign["target_amount"]) {
            $this->campaign->complete($campaignId);
        }

        $this->pdo->commit();

        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();

        return $e->getMessage();
    }
}



    /**
     * Lấy danh sách lịch sử quyên góp của người dùng từ Model
     */
    public function getUserDonations($userId)
    {
        return $this->donation->getUserDonations($userId);
    }

    public function getCampaignDonations($campaignId)
    {
        return $this->donation->getCampaignDonations($campaignId);
    }

    public function getAllDonations()
    {
        return $this->donation->getAllDonations();
    }
}
