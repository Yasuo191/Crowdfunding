<?php

require_once "../models/Favorite.php";

class FavoriteService
{
    private $favorite;

    public function __construct($pdo)
    {
        $this->favorite = new Favorite($pdo);
    }

    public function toggle($userId, $campaignId)
    {
        if ($this->favorite->exists($userId, $campaignId)) {

            $this->favorite->remove(
                $userId,
                $campaignId
            );

            return "removed";
        }

        $this->favorite->add(
            $userId,
            $campaignId
        );

        return "added";
    }

    public function myFavorites($userId)
    {
        return $this->favorite->getMyFavorites($userId);
    }

    public function isFavorite($userId, $campaignId)
    {
        return $this->favorite->exists(
            $userId,
            $campaignId
        );
    }
}