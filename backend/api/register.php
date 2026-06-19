<?php

require "../config/database.php";

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

$password_hash =
password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql =
"
INSERT INTO users
(username,email,password_hash)
VALUES
(?,?,?)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $username,
    $email,
    $password_hash
]);

echo "Đăng ký thành công";