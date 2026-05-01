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

$method    = $_SERVER['REQUEST_METHOD'];
$full_path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base      = '/Website_OOP/Inspection-Service/public/index.php';
$path      = str_starts_with($full_path, $base)
             ? substr($full_path, strlen($base))
             : $full_path;

if (empty($path)) {
    Response::success("Inspection Service đang chạy", ['version' => '1.0'], 200);
}

$controller = new InspectionController();

// ── POST /inspection/report — Inspector tạo báo cáo
if ($method === 'POST' && $path === '/inspection/report') {
    $controller->createReport();
}

// ── GET /inspection/stats — Thống kê + recent (cho inspection_management)
elseif ($method === 'GET' && $path === '/inspection/stats') {
    $controller->getStats();
}

// ── GET /inspection/reports — Danh sách tất cả (cho admin_approve)
elseif ($method === 'GET' && $path === '/inspection/reports') {
    $controller->getAllReports();
}

// ── GET /inspection/{bicycleId} — Báo cáo theo xe (cho report_detail)
elseif ($method === 'GET' && preg_match('#^/inspection/(\d+)$#', $path, $m)) {
    $controller->getByBicycle((int)$m[1]);
}

// ── PUT /inspection/approve — Admin duyệt
elseif ($method === 'PUT' && $path === '/inspection/approve') {
    $controller->approveReport();
}

// ── PUT /inspection/reject — Admin từ chối
elseif ($method === 'PUT' && $path === '/inspection/reject') {
    $controller->rejectReport();
}

else {
    Response::error("Endpoint không tồn tại: {$method} {$path}", 404);
}