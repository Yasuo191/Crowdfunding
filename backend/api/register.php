<?php

require "../config/database.php";

header("Content-Type: application/json; charset=UTF-8");

$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

/*

| Validate dữ liệu

*/

if ($username === "") {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "username",
        "message" => "Tên đăng nhập không được để trống"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($email === "") {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "email",
        "message" => "Email không được để trống"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "email",
        "message" => "Email không hợp lệ"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($password === "") {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "password",
        "message" => "Mật khẩu không được để trống"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "password",
        "message" => "Mật khẩu phải có ít nhất 6 ký tự"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/*

| Username đã tồn tại?

*/

$sql = "SELECT id FROM users WHERE username=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);

if ($stmt->fetch()) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "username",
        "message" => "Tên đăng nhập đã tồn tại"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/*

| Email đã tồn tại?

*/

$sql = "SELECT id FROM users WHERE email=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

if ($stmt->fetch()) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "field" => "email",
        "message" => "Email đã tồn tại"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/*

| Insert

*/

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $email, $password_hash]);

echo json_encode([
    "success" => true,
    "message" => "Đăng ký thành công"
], JSON_UNESCAPED_UNICODE);