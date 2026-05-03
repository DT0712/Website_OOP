<?php
require_once __DIR__ . '/../services/PaymentService.php';
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../../config/database.php';

class PaymentController {

    // ================================
    // CREATE PAYMENT
    // ================================
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

    // ================================
    // UPDATE PAYMENT (DÙNG CHUNG ENDPOINT)
    // ================================
    public function update() {
        global $conn;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            Response::json([
                "status" => "error",
                "message" => "Invalid JSON"
            ], 400);
        }

        $order_id = $data['order_id'] ?? null;
        $status   = $data['status'] ?? null;

        if (!$order_id || !$status) {
            Response::json([
                "status" => "error",
                "message" => "order_id và status là bắt buộc"
            ], 400);
        }

        try {
            $paymentModel = new Payment($conn);

            $updated = $paymentModel->updateStatus($order_id, $status);

            if (!$updated) {
                Response::json([
                    "status" => "error",
                    "message" => "Cập nhật thất bại"
                ], 500);
            }

            Response::json([
                "status" => "success",
                "message" => "Cập nhật trạng thái thành công"
            ]);

        } catch (Exception $e) {
            Response::json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

    // ================================
    // GET PAYMENT
    // ================================
    public function show() {
        global $conn;

        $order_id = $_GET['order_id'] ?? null;

        if (!$order_id) {
            Response::json([
                "status" => "error",
                "message" => "Missing order_id"
            ], 400);
        }

        try {
            $paymentModel = new Payment($conn);
            $payment = $paymentModel->findByOrderId($order_id);

            if (!$payment) {
                Response::json([
                    "status" => "error",
                    "message" => "Not found"
                ], 404);
            }

            Response::json([
                "status" => "success",
                "data" => $payment
            ]);

        } catch (Exception $e) {
            Response::json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }
}