<?php

require_once "../models/Campaign.php";

class AdminService
{
    private Campaign $campaign;

    public function __construct(PDO $pdo)
    {
        $this->campaign = new Campaign($pdo);
    }

    public function getPendingCampaigns()
    {
        return $this->campaign->getPendingCampaigns();
    }

    public function approveCampaign($id)
    {
        return $this->campaign->approve($id);
    }

    public function rejectCampaign($id)
    {
        return $this->campaign->reject($id);
    }
}