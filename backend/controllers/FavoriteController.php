<?php

require_once "../services/FavoriteService.php";

class FavoriteController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new FavoriteService($pdo);
    }

    public function toggle()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Bạn chưa đăng nhập"
            ], JSON_UNESCAPED_UNICODE);

            exit;
        }

        $campaignId = $_POST["campaign_id"] ?? 0;

        $result = $this->service->toggle(
            $_SESSION["user_id"],
            $campaignId
        );

        echo json_encode([
            "success" => true,
            "status" => $result
        ], JSON_UNESCAPED_UNICODE);
    }

    public function myFavorites()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {

            http_response_code(401);

            echo json_encode([
                "success" => false
            ]);

            exit;
        }

        echo json_encode(
            $this->service->myFavorites($_SESSION["user_id"])
        );
    }

    public function isFavorite()
    {
        header("Content-Type: application/json; charset=UTF-8");

        if (!isset($_SESSION["user_id"])) {

            echo json_encode([
                "favorite" => false
            ]);

            return;
        }

        $campaignId = $_GET["campaign_id"] ?? 0;

        echo json_encode([
            "favorite" => $this->service->isFavorite(
                $_SESSION["user_id"],
                $campaignId
            )
        ]);
    }
}