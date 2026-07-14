<?php

class Favorite
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function exists($userId, $campaignId)
    {
        $sql = "
            SELECT 1
            FROM favorites
            WHERE user_id = ?
            AND campaign_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $campaignId]);

        return $stmt->fetchColumn();
    }

    public function add($userId, $campaignId)
    {
        $sql = "
            INSERT INTO favorites
            (user_id, campaign_id)
            VALUES (?,?)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $userId,
            $campaignId
        ]);
    }

    public function remove($userId, $campaignId)
    {
        $sql = "
            DELETE FROM favorites
            WHERE user_id = ?
            AND campaign_id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $userId,
            $campaignId
        ]);
    }

    public function getMyFavorites($userId)
    {
        $sql = "
            SELECT
                c.*
            FROM favorites f
            JOIN campaigns c
                ON c.id = f.campaign_id
            WHERE f.user_id = ?
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}