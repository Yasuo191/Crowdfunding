<?php

session_start();

if(isset($_SESSION["user_id"]))
{
    echo "Xin chào "
        . $_SESSION["username"];

    echo "<br><br>";

    echo "<a href='logout.php'>
            Đăng xuất
          </a>";
}
else
{
    echo "Chưa đăng nhập";
}