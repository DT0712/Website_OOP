<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "oop_bicycle_system";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("DB chưa kết nối");
}

mysqli_set_charset($conn, "utf8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>