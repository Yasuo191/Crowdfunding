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
            )->fetchColumn()

        ];
    }
}