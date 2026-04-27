<?php
// public/index.php

// Hiển thị lỗi (dev thôi, deploy thì tắt)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CORS (nếu gọi từ service khác hoặc frontend khác domain)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load routes
require_once __DIR__ . '/../routes/api.php';