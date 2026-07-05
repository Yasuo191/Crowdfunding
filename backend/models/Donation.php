<?php

class Donation
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Thêm lượt quyên góp
    public function create($userId, $campaignId, $amount, $message)
    {
        $sql = "
            INSERT INTO donations
            (user_id, campaign_id, amount, message)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $userId,
            $campaignId,
            $amount,
            $message
        ]);
    }

    // Cập nhật tổng tiền của chiến dịch
    public function updateCampaignAmount($campaignId, $amount)
    {
        $sql = "
            UPDATE campaigns
            SET current_amount = current_amount + ?
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $amount,
            $campaignId
        ]);
    }

    // Lấy lịch sử quyên góp của người dùng
    public function getUserDonations($userId)
    {
        $sql = "
            SELECT
                d.id,
                c.title,
                d.amount,
                d.message,
                d.donated_at
            FROM donations d
            JOIN campaigns c
                ON d.campaign_id = c.id
            WHERE d.user_id = ?
            ORDER BY d.donated_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}