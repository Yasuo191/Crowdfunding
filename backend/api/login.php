<?php

session_start();

require "../config/database.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$sql =
"
SELECT
id,
username,
email,
password_hash,
role
FROM users
WHERE email = ?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// --- ĐOẠN ĐÃ THAY THẾ THEO YÊU CẦU ---
header("Content-Type: application/json; charset=UTF-8");

if($user && password_verify($password, $user["password_hash"]))
{
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["role"] = $user["role"];

    echo json_encode([
        "success" => true,
        "message" => "Đăng nhập thành công"
    ]);
}
else
{
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Sai email hoặc mật khẩu"
    ]);
}
