<?php

require_once "../models/Campaign.php";

class CampaignService
{
    private Campaign $campaign;

    public function __construct(PDO $pdo)
    {
        $this->campaign = new Campaign($pdo);
    }

    /**
     * Tạo chiến dịch mới
     */
    public function createCampaign(

$creatorId,

$title,

$description,

$targetAmount,

$image,

$startDate,

$endDate
)
    {
        if (empty($title)) {
            return "Tên chiến dịch không được để trống";
        }

        if ($targetAmount <= 0) {
            return "Mục tiêu gây quỹ phải lớn hơn 0";
        }

        $result = $this->campaign->create(

$creatorId,

$title,

$description,

$targetAmount,

$image,

$startDate,

$endDate

);

        return $result ? true : "Không thể tạo chiến dịch";
    }

    /**
     * Danh sách toàn bộ chiến dịch
     */
    public function getAllCampaigns()
    {
        return $this->campaign->getAll();
    }

    /**
     * Chi tiết chiến dịch theo ID
     */
    public function getCampaignById($id)
    {
        return $this->campaign->getById($id);
    }

    /**
     * Xác thực quyền sở hữu và cập nhật chiến dịch
     */
    public function updateCampaign(
        $id,
        $userId,
        $title,
        $description,
        $targetAmount,
        $startDate,
        $endDate
    ) {
        $currentCampaign = $this->campaign->getById($id);

        if (!$currentCampaign) {
            return "Chiến dịch không tồn tại";
        }

        if ($currentCampaign["creator_id"] != $userId) {
            return "Bạn không có quyền chỉnh sửa chiến dịch này";
        }

        if (empty($title)) {
            return "Tên chiến dịch không được để trống";
        }

        if ($targetAmount <= 0) {
            return "Mục tiêu gây quỹ phải lớn hơn 0";
        }
        
        if ($targetAmount < $currentCampaign["current_amount"]) {
            return "Mục tiêu mới không được nhỏ hơn số tiền hiện tại đã quyên góp (" . number_format($currentCampaign["current_amount"]) . "đ)";
        }

        $result = $this->campaign->update(
            $id,
            $title,
            $description,
            $targetAmount,
            $startDate,
            $endDate
        );

        return $result ? true : "Không thể cập nhật chiến dịch";
    }

    /**
     * Kiểm tra phân quyền (Creator/Admin) và xóa mềm chiến dịch
     */
    public function deleteCampaign($id, $userId, $userRole = 'user')
    {
        $campaign = $this->campaign->getById($id);

        if (!$campaign) {
            return "Chiến dịch không tồn tại";
        }

        // Cho phép xóa nếu là người tạo HOẶC là admin
        if ($campaign["creator_id"] != $userId && $userRole !== "admin") {
            return "Bạn không có quyền xóa chiến dịch này";
        }

        $result = $this->campaign->delete($id);

        return $result ? true : "Không thể xóa chiến dịch";
    }

    public function getMyCampaigns($userId)
{
    return $this->campaign->getByCreator($userId);
}

public function searchCampaign($keyword)
{
    return $this->campaign->search($keyword);
}

public function getAllCampaignsForAdmin()
{
    return $this->campaign->getAllForAdmin();
}

public function restoreCampaign($id)
{
    return $this->campaign->restore($id);
}

public function completeCampaign($id)
{
    return $this->campaign->complete($id);
}
}