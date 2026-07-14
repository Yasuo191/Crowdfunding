<?php

require_once "../services/CommentService.php";

class CommentController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new CommentService($pdo);
    }

    public function add()
    {
        session_start();

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Unauthorized"
            ]);
            return;
        }

        $campaignId = $_POST["campaign_id"] ?? null;
        $content = $_POST["content"] ?? "";

        $result = $this->service->addComment(
            $campaignId,
            $_SESSION["user_id"],
            $content
        );

        echo json_encode($result);
    }

    public function index()
    {
        $campaignId = $_GET["campaign_id"] ?? null;

        echo json_encode(
            $this->service->getComments($campaignId)
        );
    }
}