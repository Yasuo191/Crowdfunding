<?php

require_once "../models/Comment.php";

class CommentService
{
    private $commentModel;

    public function __construct($pdo)
    {
        $this->commentModel = new Comment($pdo);
    }

    public function addComment($campaignId, $userId, $content)
    {
        $content = trim($content);

        if (empty($content)) {
            return [
                "success" => false,
                "message" => "Nội dung bình luận không được để trống."
            ];
        }

        $this->commentModel->create(
            $campaignId,
            $userId,
            $content
        );

        return [
            "success" => true,
            "message" => "Bình luận thành công."
        ];
    }

    public function getComments($campaignId)
    {
        return $this->commentModel->getByCampaign($campaignId);
    }
}