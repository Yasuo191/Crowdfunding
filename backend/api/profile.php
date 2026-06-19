<?php
session_start();
if(isset($_SESSION["user_id"]))
{
    echo "Xin chào "
        . $_SESSION["username"];
}
else
{
    echo "Chưa đăng nhập";
}