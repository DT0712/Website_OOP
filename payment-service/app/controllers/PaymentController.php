<?php
require_once __DIR__ . '/../services/PaymentService.php';
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../../config/database.php';

class PaymentController {

    // POST /payments
    public function create() {
        global $conn;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            Response::json([
                "status" => "error",
                "message" => "Invalid JSON"
            ], 400);
        }

        $order_id = $data['order_id'] ?? null;
        $amount   = $data['amount'] ?? 0;
        $method   = $data['method'] ?? 'cod';

        if (!$order_id) {
            Response::json([
                "status" => "error",
                "message" => "order_id is required"
            ], 400);
        }

        try {
            $service = new PaymentService($conn);
            $result = $service->process($order_id, $amount, $method);

            Response::json($result);

        } catch (Exception $e) {
            Response::json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    // GET /payments?order_id=...
    public function show() {
        global $conn;

        $order_id = $_GET['order_id'] ?? null;

        if (!$order_id) {
            Response::json(["error" => "Missing order_id"], 400);
        }

        $paymentModel = new Payment($conn);
        $payment = $paymentModel->findByOrderId($order_id);

        if (!$payment) {
            Response::json(["error" => "Not found"], 404);
        }

        Response::json($payment);
    }
}