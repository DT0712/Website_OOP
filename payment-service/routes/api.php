<?php
require_once __DIR__ . '/../app/controllers/PaymentController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Nếu đang dùng /payment-service/public
$uri = str_replace('/payment-service/public', '', $uri);

$controller = new PaymentController();

if ($uri === '/payments' && $method === 'POST') {
    $controller->create();
} 
elseif ($uri === '/payments' && $method === 'GET') {
    $controller->show();
}
else {
    echo json_encode(["error" => "Route not found"]);
}