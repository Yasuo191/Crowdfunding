<?php

class Dashboard
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStatistics()
    {
        return [

            "total_users" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM users"
            )->fetchColumn(),

            "total_campaigns" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM campaigns"
            )->fetchColumn(),

            "pending_campaigns" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM campaigns
                 WHERE status='pending'"
            )->fetchColumn(),

            "active_campaigns" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM campaigns
                 WHERE status='active'"
            )->fetchColumn(),

            "completed_campaigns" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM campaigns
                 WHERE status='completed'"
            )->fetchColumn(),

            "deleted_campaigns" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM campaigns
                 WHERE status='deleted'"
            )->fetchColumn(),

            "total_donations" =>
            $this->pdo->query(
                "SELECT COUNT(*) FROM donations"
            )->fetchColumn(),

            "total_amount" =>
            $this->pdo->query(
                "SELECT IFNULL(SUM(amount),0)
                 FROM donations"
            )->fetchColumn(),

            "campaign_progress" =>
            $this->pdo->query(
                "SELECT
                    title,
                    current_amount,
                    target_amount
                 FROM campaigns
                 WHERE status <> 'deleted'
                 ORDER BY created_at DESC"
            )->fetchAll(PDO::FETCH_ASSOC),

            "donation_by_day" =>
            $this->pdo->query(
                "SELECT
                    DATE(donated_at) AS day,
                    SUM(amount) AS total
                 FROM donations
                 GROUP BY DATE(donated_at)
                 ORDER BY day"
            )->fetchAll(PDO::FETCH_ASSOC)

        ];
    }
}
