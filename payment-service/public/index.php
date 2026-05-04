<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/controllers/PaymentController.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

$controller = new PaymentController();

// 👉 CHỈ 1 ROUTE DUY NHẤT
if ($method === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    // 👉 nếu có status = update
    if (isset($data['status'])) {
        $controller->update();
    } 
    // 👉 không có = create
    else {
        $controller->create();
    }

    exit;
}

// TEST SERVICE
if ($method === 'GET') {
    echo json_encode([
        "status" => "ok",
        "message" => "Payment Service Running"
    ]);
    exit;
}

echo json_encode([
    "status" => "error",
    "message" => "Invalid request"
]);