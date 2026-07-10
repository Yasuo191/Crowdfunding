<?php

require_once "../models/Dashboard.php";

class DashboardService
{
    private Dashboard $dashboard;

    public function __construct(PDO $pdo)
    {
        $this->dashboard = new Dashboard($pdo);
    }

    public function statistics()
    {
        return $this->dashboard->getStatistics();
    }
}