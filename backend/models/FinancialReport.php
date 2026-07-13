<?php

class FinancialReport
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(
        $campaignId,
        $generatedBy,
        $income,
        $expense,
        $note
    ) {
        $sql = "
            INSERT INTO financial_reports
            (
                campaign_id,
                generated_by,
                income,
                expense,
                note
            )
            VALUES
            (?, ?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $campaignId,
            $generatedBy,
            $income,
            $expense,
            $note
        ]);
    }

    public function getAll()
    {
        $sql = "
            SELECT
                fr.id,
                c.title AS campaign_title,
                u.username,
                fr.income,
                fr.expense,
                fr.note,
                fr.report_date
            FROM financial_reports fr
            JOIN campaigns c
                ON fr.campaign_id = c.id
            JOIN users u
                ON fr.generated_by = u.id
            ORDER BY fr.report_date DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCampaign($campaignId)
    {
        $sql = "
            SELECT *
            FROM financial_reports
            WHERE campaign_id = ?
            ORDER BY report_date DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$campaignId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}