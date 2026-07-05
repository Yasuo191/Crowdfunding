<?php

require_once "../models/Donation.php";

class DonationService
{
    private Donation $donation;
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->donation = new Donation($pdo);
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

        try {
            $this->pdo->beginTransaction();

            $this->donation->create(
                $userId,
                $campaignId,
                $amount,
                $message
            );

            $this->donation->updateCampaignAmount(
                $campaignId,
                $amount
            );

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
}