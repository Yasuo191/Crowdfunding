<?php
require_once "../config/database.php";
require_once "../services/UserService.php";

class UserController
{
    private UserService $service;

    public function __construct(PDO $pdo)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Chỉ cho phép admin truy cập
        if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
            http_response_code(403);
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode([
                "success" => false,
                "message" => "Bạn không có quyền"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $this->service = new UserService($pdo);
    }

    // Danh sách User
    public function index(): void
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(
            $this->service->getAllUsers(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    // Đổi quyền
    public function updateRole(): void
    {
        header("Content-Type: application/json; charset=UTF-8");

        $id   = $_POST["id"]   ?? null;
        $role = $_POST["role"] ?? null;

        $result = $this->service->updateRole($id, $role);

        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Cập nhật quyền thành công"
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Lỗi"
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    // Đăng nhập
    public function login(): void
    {
        header("Content-Type: application/json; charset=UTF-8");

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

        $user = $this->service->login($username, $password);

        if ($user) {
            // Lưu thông tin vào session
            $_SESSION["user_id"]   = $user["id"];
            $_SESSION["username"]  = $user["username"];
            $_SESSION["role"]      = $user["role"];

            echo json_encode([
                "success" => true,
                "message" => "Đăng nhập thành công",
                "user" => [
                    "id"       => $user["id"],
                    "username" => $user["username"],
                    "email"    => $user["email"],
                    "role"     => $user["role"]
                ]
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Sai tài khoản hoặc mật khẩu"
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
