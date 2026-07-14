<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit;
}

require_once "../config/database.php";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=financial_reports.csv");

$output = fopen("php://output", "w");

fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, [
    "ID",
    "Campaign",
    "Creator",
    "Income",
    "Expense",
    "Note",
    "Report Date"
]);

$sql = "
SELECT
    fr.id,
    c.title,
    u.username,
    fr.income,
    fr.expense,
    fr.note,
    fr.report_date
FROM financial_reports fr
JOIN campaigns c
ON fr.campaign_id=c.id
JOIN users u
ON fr.generated_by=u.id
ORDER BY fr.id DESC
";

$stmt = $pdo->query($sql);

while($row=$stmt->fetch(PDO::FETCH_NUM)){
    fputcsv($output,$row);
}

fclose($output);
exit;