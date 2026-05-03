<?php

// ====== THÔNG TIN KẾT NỐI ======
$host = "localhost";
$user = "root";
$password = "";
$database = "oop_bicycle_system";

// ====== KẾT NỐI DATABASE ======
$conn = mysqli_connect($host, $user, $password, $database);

// Kiểm tra lỗi kết nối
if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($conn, "utf8");

// ====== SESSION ======
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}