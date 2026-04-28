<?php
// Cho phép gọi từ domain khác 
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

$method = $_SERVER['REQUEST_METHOD'];   // GET, POST, PUT
$uri    = $_SERVER['REQUEST_URI'];      // /inspection/report, /inspection/5

$full_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$full_path = rtrim($full_path, '/');

$base      = '/Website_OOP/InspectionService/public/index.php';
$path      = str_starts_with($full_path, $base)
             ? substr($full_path, strlen($base))
             : $full_path;

if (empty($path)) {
    Response::error("Inspection Service dang chay. Vui long goi dung endpoint.", 200);
}
$controller = new InspectionController();

if ($method === 'POST' && $path === '/inspection/report') {
    $controller->createReport();
}

elseif ($method === 'GET' && preg_match('#^/inspection/(\d+)$#', $path, $m)) {
    $controller->getByBicycle((int)$m[1]);
}

elseif ($method === 'PUT' && $path === '/inspection/approve') {
    $controller->approveReport();
}

else {
    Response::error("Endpoint không tồn tại: {$method} {$path}", 404);
}