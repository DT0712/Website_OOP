<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $msg = $_POST["message"] ?? "";

    // Test đơn giản trước
    echo "Bạn vừa hỏi: " . $msg;

    // Sau này mới tích hợp AI thật
}