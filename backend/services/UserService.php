<?php

require_once "../models/User.php";

class UserService
{
    private User $user;

    public function __construct(PDO $pdo)
    {
        $this->user = new User($pdo);
    }

    public function register($username, $email, $password)
    {
        // 1. Kiểm tra không được để trống dữ liệu (có dùng trim)
        if (trim($username) === "") {
            return [
                "success" => false,
                "field" => "username",
                "message" => "Tên đăng nhập không được để trống"
            ];
        }

        if (trim($email) === "") {
            return [
                "success" => false,
                "field" => "email",
                "message" => "Email không được để trống"
            ];
        }

        if (trim($password) === "") {
            return [
                "success" => false,
                "field" => "password",
                "message" => "Mật khẩu không được để trống"
            ];
        }

        // 2. Kiểm tra định dạng Email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                "success" => false,
                "field" => "email",
                "message" => "Email không hợp lệ"
            ];
        }

        // 3. Kiểm tra độ dài Mật khẩu tối thiểu 6 ký tự
        if (strlen($password) < 6) {
            return [
                "success" => false,
                "field" => "password",
                "message" => "Mật khẩu tối thiểu 6 ký tự"
            ];
        }

    }

    public function getAllUsers()
    {
        return $this->user->getAllUsers();
    }

    public function updateRole($id, $role)
    {
        if (
            $role != "user" &&
            $role != "admin"
        ) {
            return false;
        }

        return $this->user->updateRole(
            $id,
            $role
        );
    }
}