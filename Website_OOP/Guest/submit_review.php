<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['khach_hang'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['khach_hang']['id'];
$bicycle_id = (int)$_POST['bicycle_id'];
$rating = (float)$_POST['rating'];
$comment = trim($_POST['comment']);

/* VALID */
if ($rating < 1 || $rating > 5) {
    die("Rating không hợp lệ");
}

/* INSERT */
$stmt = $conn->prepare("
INSERT INTO reviews (bicycle_id, user_id, rating, comment) 
VALUES (?, ?, ?, ?)
");

$stmt->bind_param("iids", $bicycle_id, $user_id, $rating, $comment);

if ($stmt->execute()) {
    header("Location: detail.php?id=" . $bicycle_id);
} else {
    echo "Lỗi: " . $stmt->error;
}