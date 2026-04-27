<?php
// config/database.php

$host = "localhost";
$username = "root";
$password = "";
$database = "your_database"; // 🔥 đổi thành DB của bạn

$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("❌ Kết nối DB thất bại: " . $conn->connect_error);
}



