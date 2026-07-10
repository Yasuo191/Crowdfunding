<?php

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy toàn bộ người dùng
    public function getAllUsers()
    {
        $sql = "
            SELECT
                id,
                username,
                email,
                role,
                created_at
            FROM users
            ORDER BY created_at DESC
        ";

        return $this->pdo
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật quyền
    public function updateRole($id, $role)
    {
        $sql = "
            UPDATE users
            SET role = ?
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$role, $id]);
    }

    // Lấy thông tin người dùng theo ID
    public function getById($id)
    {
        $sql = "
            SELECT
                id,
                username,
                email,
                role,
                created_at
            FROM users
            WHERE id = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
