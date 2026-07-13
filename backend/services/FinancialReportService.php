<?php

require_once "../models/FinancialReport.php";

class FinancialReportService
{
    private $report;

    public function __construct($pdo)
    {
        $this->report = new FinancialReport($pdo);
    }

    public function create(
        $campaignId,
        $generatedBy,
        $income,
        $expense,
        $note
    ) {
        if ($campaignId <= 0) {
            return false;
        }

        if ($income < 0 || $expense < 0) {
            return false;
        }

        return $this->report->create(
            $campaignId,
            $generatedBy,
            $income,
            $expense,
            $note
        );
    }

    public function getAll()
    {
        return $this->report->getAll();
    }

    public function getByCampaign($campaignId)
    {
        return $this->report->getByCampaign($campaignId);
    }
}