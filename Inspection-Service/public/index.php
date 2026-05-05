<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-User-Id, X-User-Role");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../app/helpers/Response.php';
require_once __DIR__ . '/../app/controllers/InspectionController.php';

$method = $_SERVER['REQUEST_METHOD'];

/**
 * 🔥 LẤY PATH CHUẨN (FIX TOÀN BỘ LỖI TRƯỚC)
 */
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// loại bỏ base path nếu có
$basePath = '/Website_OOP/Inspection-Service/public';
$path = str_replace($basePath, '', $requestUri);

// loại bỏ index.php nếu có
$path = str_replace('/index.php', '', $path);

// chuẩn hóa path (quan trọng)
$path = '/' . trim($path, '/');

/**
 * Debug nếu cần
 */
// echo json_encode(['path' => $path, 'method' => $method]); exit;

/**
 * ROUTING
 */
$controller = new InspectionController();

// Root
if ($path === '/' || $path === '') {
    Response::success("Inspection Service đang chạy", ['version' => '1.0'], 200);
}

// POST /inspection/report
elseif ($method === 'POST' && $path === '/inspection/report') {
    $controller->createReport();
}

// GET /inspection/stats
elseif ($method === 'GET' && $path === '/inspection/stats') {
    $controller->getStats();
}

// GET /inspection/reports
elseif ($method === 'GET' && $path === '/inspection/reports') {
    $controller->getAllReports();
}

// GET /inspection/{id}
elseif ($method === 'GET' && preg_match('#^/inspection/(\d+)$#', $path, $m)) {
    $controller->getByBicycle((int)$m[1]);
}

// PUT /inspection/approve
elseif ($method === 'PUT' && $path === '/inspection/approve') {
    $controller->approveReport();
}

// PUT /inspection/reject
elseif ($method === 'PUT' && $path === '/inspection/reject') {
    $controller->rejectReport();
}

// NOT FOUND
else {
    Response::error("Endpoint không tồn tại: {$method} {$path}", 404);
}