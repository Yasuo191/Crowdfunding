<?php

class Campaign
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Tạo một chiến dịch mới
     */
    public function create(
        $creatorId,
        $title,
        $description,
        $targetAmount,
        $startDate,
        $endDate
    ) {
        $sql = "
            INSERT INTO campaigns
            (
                creator_id,
                title,
                description,
                target_amount,
                start_date,
                end_date
            )
            VALUES
            (?,?,?,?,?,?)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $creatorId,
            $title,
            $description,
            $targetAmount,
            $startDate,
            $endDate
        ]);
    }

    /**
     * Lấy toàn bộ danh sách chiến dịch kèm theo tên người tạo
     */
    public function getAll()
    {
        $sql = "
            SELECT
                c.id,
                c.title,
                c.description,
                c.target_amount,
                c.current_amount,
                c.image_url,
                c.start_date,
                c.end_date,
                c.status,
                c.created_at,
                u.username AS creator
            FROM campaigns c
            JOIN users u
                ON c.creator_id = u.id
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết một chiến dịch theo ID kèm theo tên người tạo
     */
    public function getById($id)
    {
        $sql = "
            SELECT
                c.id,
                c.creator_id,
                c.title,
                c.description,
                c.target_amount,
                c.current_amount,
                c.image_url,
                c.start_date,
                c.end_date,
                c.status,
                c.created_at,
                u.username AS creator
            FROM campaigns c
            JOIN users u
                ON c.creator_id = u.id
            WHERE c.id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật thông tin chiến dịch theo ID
     */
    public function update(
        $id,
        $title,
        $description,
        $targetAmount,
        $startDate,
        $endDate
    ) {
        $sql = "
            UPDATE campaigns
            SET
                title = ?,
                description = ?,
                target_amount = ?,
                start_date = ?,
                end_date = ?
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $title,
            $description,
            $targetAmount,
            $startDate,
            $endDate,
            $id
        ]);
    }

    /**
     * Xóa mềm chiến dịch bằng cách cập nhật trạng thái thành 'deleted'
     */
    public function delete($id)
    {
        $sql = "
            UPDATE campaigns
            SET status = 'deleted'
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    /**
     * Lấy danh sách các chiến dịch đang chờ duyệt
     */
    public function getPendingCampaigns()
    {
        $sql = "
            SELECT
                c.*,
                u.username AS creator
            FROM campaigns c
            JOIN users u
                ON c.creator_id = u.id
            WHERE c.status = 'pending'
            ORDER BY c.created_at DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Duyệt chiến dịch (Chuyển sang trạng thái hoạt động)
     */
    public function approve($id)
    {
        $sql = "
            UPDATE campaigns
            SET status = 'active'
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    /**
     * Từ chối chiến dịch (Chuyển sang trạng thái xóa mềm)
     */
    public function reject($id)
    {
        $sql = "
            UPDATE campaigns
            SET status = 'deleted'
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}