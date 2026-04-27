<?php
require_once __DIR__ . '/../models/Payment.php';

class PaymentService {
    private $paymentModel;

    public function __construct($conn) {
        $this->paymentModel = new Payment($conn);
    }

    public function process($order_id, $amount, $method) {

        // Xác định trạng thái
        if ($method === 'cod') {
            $status = 'success';
        } 
        else if ($method === 'bank') {
            $status = 'pending';
            $payment_url = "http://localhost/payment-service/fake_bank.php?order_id=" . $order_id;
        } 
        else {
            $status = 'failed';
        }

        // Lưu DB
        $payment_id = $this->paymentModel->create(
            $order_id,
            $method,
            $amount,
            $status
        );

        return [
            "status" => $status,
            "payment_id" => $payment_id,
            "payment_url" => $payment_url ?? null
        ];
    }

    // Callback update (fake bank)
    public function markAsPaid($order_id) {
        return $this->paymentModel->updateStatus($order_id, 'success');
    }
}