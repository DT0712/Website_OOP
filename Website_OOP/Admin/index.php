<?php
session_start();

// Nếu chưa đăng nhập thì về login
if (!isset($_SESSION['khach_hang'])) {
    header("Location: login.php");
    exit;
}

// Nếu đã đăng nhập -> vào dashboard
header("Location: dashboard.php");
exit;
?>