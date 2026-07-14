<?php

class Comment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($campaignId, $userId, $content)
    {
        $sql = "
            INSERT INTO comments
            (
                campaign_id,
                user_id,
                content
            )
            VALUES (?,?,?)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $campaignId,
            $userId,
            $content
        ]);
    }

    public function getByCampaign($campaignId)
    {
        $sql = "
            SELECT
                c.id,
                c.content,
                c.created_at,
                u.username
            FROM comments c
            JOIN users u
                ON c.user_id = u.id
            WHERE c.campaign_id = ?
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$campaignId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}