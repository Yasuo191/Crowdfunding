<?php

session_start();

require "../config/database.php";

$email = $_POST["email"];
$password = $_POST["password"];

$sql =
"
SELECT
id,
username,
password_hash,
role
FROM users
WHERE email = ?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(
    $user &&
    password_verify(
        $password,
        $user["password_hash"]
    )
)
{
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"];

    echo "Đăng nhập thành công";
}
else
{
    echo "Sai email hoặc mật khẩu";
}